const fs = require('fs')

if (fs.existsSync('.env')) {
    const content = fs.readFileSync('.env').toString()
    const regex = new RegExp("###> @vue/vue ###\n(.*?)\n###< @vue/vue ###", 'gs')
    const match = regex.exec(content)

    module.exports = match ?
        match[1]
            .split("\n")
            .filter(line => !line.startsWith('#'))
            .reduce((acc, value) => {
                const splitted = value.split('=')
                acc[splitted[0]] = splitted[1]
                return acc
            }, {})
        : null
}