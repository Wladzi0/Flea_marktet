function onClickBtnLike(event) {
    event.preventDefault();

    const url = this.href;
    // const spanCount = this.querySelector('#js-favourites');
    const icon = this.querySelector('i');


    axios.get(url).then(function (response) {

        // spanCount.textContent = response.data.favourite;

        if (icon.classList.contains('fas')) {
            icon.classList.replace('fas', 'far');
        } else {
            icon.classList.replace('far', 'fas');
        }
    }).catch(function (error){
        if (error.response.status===403){
            window.alert("To add this advertisement to your favourite you have to login")
        }
    });

}

document.querySelectorAll('#js-favourite').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
})