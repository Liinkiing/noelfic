const setDisabledBasedOnInputAndCheckboxes = ($elToDisable, $input, $checkboxes) => {
    if ($input.value === "" && $checkboxes.length === 0) {
        $elToDisable.setAttribute('disabled', 'disabled')
    } else {
        $elToDisable.removeAttribute('disabled')
    }
}

document.addEventListener('DOMContentLoaded', () => {

    const $searchForm = document.getElementById('searchForm')
    const $searchButton = document.getElementById('searchButton')
    const $searchInput = document.getElementById('searchInput')
    let $checkboxes = document.querySelectorAll('#searchForm input[type="checkbox"]:checked')

    setDisabledBasedOnInputAndCheckboxes($searchButton, $searchInput, $checkboxes)

    $searchInput.addEventListener('keyup', () => {
        setDisabledBasedOnInputAndCheckboxes($searchButton, $searchInput, $checkboxes)
    })

    $searchForm.addEventListener('change', () => {
        $checkboxes = document.querySelectorAll('#searchForm input[type="checkbox"]:checked');
        setDisabledBasedOnInputAndCheckboxes($searchButton, $searchInput, $checkboxes)
    })

})