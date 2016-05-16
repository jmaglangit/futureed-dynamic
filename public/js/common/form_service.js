

function labelToForm(){

    //change child
    $(".form-label").replaceWith(function(){

        //TODO: check for countries into drop down.

            return  '<input class="' + this.classList.value + '" type="text" value="'
                + this.textContent +'" name="'+ this.getAttribute('name') +'">';
    });
}

function formToLabel(){

    //change child expects form
    $(".form-label").replaceWith(function(){

        //check if label is country.
        if(this.getAttribute('name') == 'user_country'){

            // TODO: get countries from api -- self.country_list
        //<option value="volvo">Volvo</option> TODO: generate for each country.


            return '<select class="' + this.classList.value
                + '" name='+ this.getAttribute('name') + '>'+ this.value +'</select>';
        }else {
            return '<label class="' + this.classList.value
                + '" name='+ this.getAttribute('name') + '>'+ this.value +'</label>';
        }

    });
}