import test from 'node:test';
import assert from 'node:assert/strict';
import fs from 'node:fs/promises';
import { createHash } from 'node:crypto';
import sharp from 'sharp';

test('generated variants preserve seven registered originals, full frame and lower byte size', async () => {
    const manifest = JSON.parse(await fs.readFile('resources/images/responsive/manifest.json', 'utf8'));
    const register = JSON.parse(await fs.readFile('../docs/evidence/P1-DESIGN-media-register.json', 'utf8'));
    assert.equal(Object.keys(manifest).length, 7);
    for (const photo of Object.values(manifest)) {
        const original = photo.variants.at(-1);
        assert.equal(original.sha256, register.assets.find(a => a.path === `site/${original.path}`).sha256);
        assert.equal(new Set(photo.variants.map(v => v.width)).size, photo.variants.length);
        for (const variant of photo.variants) {
            const bytes = await fs.readFile(variant.path);
            const meta = await sharp(bytes).metadata();
            assert.equal(createHash('sha256').update(bytes).digest('hex'), variant.sha256);
            assert.equal(meta.width, variant.width);
            assert.equal(meta.height, variant.height);
            assert.ok(Math.abs(meta.height - photo.height * meta.width / photo.width) <= 1);
            assert.ok(meta.width <= photo.width);
            if (variant !== original) assert.ok(bytes.length < original.bytes);
        }
    }
});

test('all variants are emitted in the production Vite manifest', async () => {
    const images = JSON.parse(await fs.readFile('resources/images/responsive/manifest.json', 'utf8'));
    const vite = JSON.parse(await fs.readFile('public/build/manifest.json', 'utf8'));
    for (const photo of Object.values(images)) for (const variant of photo.variants) {
        assert.ok(vite[variant.path]?.file, variant.path);
        const bytes = await fs.readFile(`public/build/${vite[variant.path].file}`);
        assert.equal(createHash('sha256').update(bytes).digest('hex'), variant.sha256);
    }
});
