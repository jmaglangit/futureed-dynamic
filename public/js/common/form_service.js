function labelToForm() {

    //change child
    $(".form-label").replaceWith(function () {


        return '<input class="' + this.classList.value + '" type="text" value="'
            + this.textContent + '" name="' + this.getAttribute('name') + '">';
    });
}

function formToLabel() {

    //change child expects form
    $(".form-label").replaceWith(function () {

        //check if label is country.
        if (this.getAttribute('name') == 'user_country') {


        } else {
            return '<label class="' + this.classList.value
                + '" name=' + this.getAttribute('name') + '>' + this.value + '</label>';
        }

    });
}