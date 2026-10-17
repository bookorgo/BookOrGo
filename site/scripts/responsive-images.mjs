import fs from 'node:fs/promises';
import assert from 'node:assert/strict';
import { createHash } from 'node:crypto';
import sharp from 'sharp';

// Build-only derivatives. Never replace originals, crop, upscale or fetch remote media.
const register = JSON.parse(await fs.readFile('../docs/evidence/P1-DESIGN-media-register.json', 'utf8'));
const photos = register.assets.filter(asset => asset.path.startsWith('site/resources/images/'));
const manifest = {};
await fs.mkdir('resources/images/responsive', { recursive: true });
for (const asset of photos) {
    const input = asset.path.replace(/^site\//, '');
    const bytes = await fs.readFile(input);
    const hash = createHash('sha256').update(bytes).digest('hex');
    assert.equal(hash, asset.sha256, `original provenance hash: ${input}`);
    const metadata = await sharp(bytes).metadata();
    assert.ok(metadata.width && metadata.height && !metadata.orientation, 'known unrotated source geometry');
    const name = input.split('/').at(-1).replace('.webp', '');
    const variants = [];
    for (const width of [320, 480, 640, 960].filter(width => width < metadata.width)) {
        const path = `resources/images/responsive/${name}-${width}.webp`;
        const output = await sharp(bytes).resize({ width, withoutEnlargement: true }).webp({ quality: 85, effort: 6 }).toBuffer();
        const info = await sharp(output).metadata();
        assert.equal(info.width, width);
        assert.ok(Math.abs(info.height - metadata.height * width / metadata.width) <= 1, 'whole frame preserved');
        // Near-original re-encoding can cost more bytes. Omit that candidate, retain original fallback.
        if (output.length >= bytes.length) { console.log(`Omit non-saving candidate: ${name}-${width}`); continue; }
        await fs.writeFile(path, output);
        variants.push({ path, width, height: info.height, bytes: output.length, sha256: createHash('sha256').update(output).digest('hex') });
    }
    variants.push({ path: input, width: metadata.width, height: metadata.height, bytes: bytes.length, sha256: hash });
    manifest[name] = { width: metadata.width, height: metadata.height, variants };
    assert.equal(createHash('sha256').update(await fs.readFile(input)).digest('hex'), hash, 'original unchanged');
}
await fs.writeFile('resources/images/responsive/manifest.json', JSON.stringify(manifest, null, 2));
console.log(`Responsive image build: ${photos.length} original hashes preserved; ${Object.values(manifest).reduce((sum, item) => sum + item.variants.length - 1, 0)} smaller derivatives; no crop/upscale.`);
