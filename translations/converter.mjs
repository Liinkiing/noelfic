import fs from 'fs'
import ymljs from 'yamljs'

const locales = ['fr', 'en']

locales.forEach(locale => {
    const filename = `messages.${locale}`;
    const json = ymljs.parseFile(`translations/${filename}.yaml`)
    fs.writeFileSync(`translations/${filename}.json`, JSON.stringify(json, null, 2))
})