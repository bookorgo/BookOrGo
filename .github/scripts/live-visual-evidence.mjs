import { chromium } from '/tmp/bookorgo-visual/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';
const output = 'site/test-results/live-visual';
await fs.mkdir(output, { recursive: true });
const browser = await chromium.launch();
const evidence = [];
const errors = [];
try {
 for (const width of [1440,390]) {
  const page = await browser.newPage({viewport:{width,height:1000}});
  page.on('pageerror', e => errors.push(e.message));
  for (const [name,path] of [['home','/'],['listing','/search?q=boat'],['detail','/cruises/dubai/sample-creek-cruise']]) {
   const response = await page.goto('https://bookorgo.com'+path, {waitUntil:'networkidle'});
   assert.equal(response.status(),200);
   assert.equal(response.headers()['x-robots-tag'],'noindex, nofollow');
   const images = await page.locator('img.destination-photo').evaluateAll(async images => Promise.all(images.map(async image => {
    image.loading='eager'; await image.decode();
    return {src:image.currentSrc,loaded:image.complete && image.naturalWidth>0,sameOrigin:new URL(image.currentSrc).origin===location.origin};
   })));
   assert.ok(images.length>0 && images.every(i=>i.loaded && i.sameOrigin));
   await page.evaluate(async()=>{await document.fonts.ready;await new Promise(resolve=>requestAnimationFrame(()=>requestAnimationFrame(resolve)));});
   assert.ok(await page.evaluate(()=>document.documentElement.scrollWidth<=innerWidth));
   await page.screenshot({path:output+'/'+name+'-'+width+'.png',fullPage:true});
   evidence.push({name,width,images:images.length,loaded:true,overflow:false});
  }
  await page.close();
 }
 assert.deepEqual(errors,[]);
 await fs.writeFile(output+'/evidence.json',JSON.stringify({evidence,pageErrors:errors,readOnly:true},null,2));
} finally { await browser.close(); }
