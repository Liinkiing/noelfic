const setDisabledBasedOnInput = ($elToDisable, $input) => {
    if ($input.value === "") {
        $elToDisable.setAttribute('disabled', 'disabled')
    } else {
        $elToDisable.removeAttribute('disabled')
    }
}

document.addEventListener('DOMContentLoaded', () => {

    const $searchButton = document.getElementById('searchButton')
    const $searchInput = document.getElementById('searchInput')

    setDisabledBasedOnInput($searchButton, $searchInput)

    $searchInput.addEventListener('keyup', () => {
        setDisabledBasedOnInput($searchButton, $searchInput)
    })

})