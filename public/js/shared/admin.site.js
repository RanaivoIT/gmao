const addService = document.getElementById('add-service');
addService.addEventListener('click', () => {
    
    const index =Math.round(Math.random()*1000)

    let tmpl = document.getElementById('site_services').dataset.prototype.replace(/__name__/g, index)

    let div = document.createElement('div')
    div.innerHTML = tmpl

    document.getElementById('site_services').appendChild(div)

    handleDeleteButton()

})

function handleDeleteButton() {
    document.querySelectorAll('button[data-action="delete"]').forEach((e) => {
        const target = e.dataset.target
        e.addEventListener(
            'click',
            () => {
                document.getElementById(target).remove()
            }
        )
    })
}

handleDeleteButton()
