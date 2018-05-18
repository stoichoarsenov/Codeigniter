<?php
$this->load->library('session');
?>
<html>
        <head>
                <title>CodeIgniter</title>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- DROPZONE JS -->
    <script src="/assets/libraries/dropzone.js"></script>
    <style type="text/css" href="/assets/libraries/dropzone.css"></style>
    <style type="text/css" href="/assets/libraries/basic.css"></style>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>


       <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



   
  
 


    <!-- SWEET ALERT -->
  <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    
    
    


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

 <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <!-- <link rel="stylesheet" href="alert/dist/sweetalert.css"> -->

  <!-- <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/basic.min.css"></script> -->
  
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
  <!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
  


<script>
/**
 * Custom validator for letters (uppercase/lowercase) 
 * numbers 0-9
 * white space and "."
 */
$.validator.addMethod("lettersAndNumbers", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9 .]+$/i.test(value);
});
/**
 * Custom validator for numbers 0-9
 * white space and "."
 */
$.validator.addMethod("onlyNumbers", function (value, element) {
    return this.optional(element) || /^[08{789}\d{7} +]+$/i.test(value);
});

/**
 * Custom validator for only letters  that are cyrilic
 */
$.validator.addMethod("onlyBulgarianLetters", function (value, element) {
    return this.optional(element) || /^[а-яА-Я-]+$/i.test(value);
});

/**
 * Custom validator for only letters  that are cyrilic
 */
$.validator.addMethod("bulgarianLettersAndSymbols", function (value, element) {
    return this.optional(element) || /^[а-яА-Я0-9_.: "']+$/i.test(value);
});


/**
* Is it valid mail
*/
$.validator.addMethod("isMailValid", function (value, element) {
    return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value); 
});


/**
 * Custom validator for contains at least one lower-case letter
 */
$.validator.addMethod("atLeastOneLowercaseLetter", function (value, element) {
    return this.optional(element) || /[a-z]+/.test(value);
}, "Must have at least one lowercase letter");
 
/**
 * Custom validator for contains at least one upper-case letter.
 */
$.validator.addMethod("atLeastOneUppercaseLetter", function (value, element) {
    return this.optional(element) || /[A-Z]+/.test(value);
}, "Must have at least one uppercase letter");
 
/**
 * Custom validator for contains at least one number.
 */
$.validator.addMethod("atLeastOneNumber", function (value, element) {
    return this.optional(element) || /[0-9]+/.test(value);
}, "Must have at least one number");
 
/**
 * Custom validator for contains at least one symbol.
 */
$.validator.addMethod("atLeastOneSymbol", function (value, element) {
    return this.optional(element) || /[!@#$%^&*()]+/.test(value);
}, "Must have at least one symbol");


$(document).ready(function(){
    $("#createBookForm").validate({
    rules: {
        title: {
        required: true,
        minlength: 5,
        maxlength: 50,
        lettersAndNumbers: true,
        },
        author: {
            required: true,
            minlength: 5,
            maxlength: 50,
            lettersAndNumbers: true,
        },
        description: {
            required: true,
            maxlength: 150,
            lettersAndNumbers: true,
        },
        price: {
            onlyNumbers:true,
            required: true,
        }
    },
    messages: {
        title: {
        required: "Полето е задължително",
        minlength: "Трябва да съдържа поне 5 символа",
        maxlength: "Не трябва да съдържа поне 5 символа",
        lettersAndNumbers: "Само букви и цифри",
        },
        author: {
            required: "Полето е задължително",
            minlength: "Трябва да съдържа поне 5 символа",
            maxlength: "Не трябва да съдържа поне 5 символа",
            lettersAndNumbers: "Само букви и цифри",
            },
        description: {
            required: "Полето е задължително",
            minlength: "Трябва да съдържа поне 5 символа",
            maxlength: "Не трябва да съдържа поне 5 символа",
            lettersAndNumbers: "Само букви и цифри",
        },
        price: {
            onlyNumbers: "Само Цифри",
            required: "Полето е задължително",
        }
    }
    })
});


/**
* Използва се създаване на потребител без регистрация
*
*/
$(document).ready(function(){
    $("#createTempRegister").validate({

    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 50,
            onlyBulgarianLetters: true,
        },
        familyName: {
            required: true,
            minlength: 4,
            maxlength: 50,
            onlyBulgarianLetters: true,
        },
        txtEmail: {
            required :true,
            isMailValid : true,
        },
        number: {
            minlength: 10,
            maxlength: 13,
            onlyNumbers:true,
            required: true,
        },
        comment: {
            maxlength: 150,
            bulgarianLettersAndSymbols: true,
        },
        chooseCity:{
            required: true,
        },
        adress:{
            required: true,
            minlength: 3,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        }
    },
    messages: {
            name: {
                required: "Полето е задължително",
                minlength: "Трябва да съдържа 9 символа",
                maxlength: "Tрябва да съдържа 9 символа",
                onlyBulgarianLetters: "Само символи на кирлица",
            },
            familyName: {
                required: "Полето е задължително",
                minlength: "Трябва да съдържа поне 4 символа",
                maxlength: "Не трябва да съдържа поне 50 символа",
                onlyBulgarianLetters: "Само символи на кирилица",
            },
            txtEmail: {
                required: "Полето е задължително",
                isMailValid: "Мейлът не е валиден",
            },
            number: {
                minlength: 'Номерът не е валиден',
                maxlength: 'Номеръ не е валиден',
                onlyNumbers: "Само Цифри",
                required: "Полето е задължително",
            },
            comment: {
                // required: "Полето е задължително",
                // minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Не трябва да съдържа повече 250 символа",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
            },
            chooseCity:{
                required: "Полето е задължително",
            },
            adress:{
                required:  "Полето е задължително",
                minlength: "Трябва да съдържа поне 3 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
            },
        }
    })
    

});

$(document).ready(function(){
    $("#registerUser").validate({
        
        // За hidden input
        // ignore: ".ignore",

    rules: {
        username:{
            required: true,
            minlength: 3,
            maxlength: 50,
        },
        userFamName:{
            required: true,
            minlength: 3,
            maxlength: 50,
        },
        registerPassword:{
            required: true,
            atLeastOneLowercaseLetter: true,
            atLeastOneUppercaseLetter: true,
            atLeastOneNumber: true,
            atLeastOneSymbol: true,
            minlength: 8,
            maxlength: 40,
        },
        passwordCheck: {
            required: true,
            equalTo: registerPassword,
        },
        phoneNumber: {
            minlength: 10,
            maxlength: 13,
            onlyNumbers:true,
            required: true,
        },
        Email: {
            required: true,
            isMailValid : true,
            // is_unique: [av_users.username]
        },
        addrArea: {
            required: true,
            minlength: 5,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        },
        addrCity: {
            required: true,
            minlength: 5,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        },
        addrNeibr: {
            required: true,
            minlength: 5,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        },
        adress: {
            required: true,
            minlength: 5,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        },
        hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
        }
    }, 
    messages: {
            username:{
                required:  "Полето е задължително",
                minlength: "Трябва да съдържа поне 3 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            userFamName:{
                required:  "Полето е задължително",
                minlength: "Трябва да съдържа поне 3 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            registerPassword: {
                required: "полето е задължително",
                atLeastOneUppercaseLetter: "Трябва да съдържа поне 1 главна буква",
                atLeastOneLowercaseLetter: "Трябва да съдържа поне 1 малка буква",
                atLeastOneNumber: "Трябва да съдържа поне 1 цифра" ,
                atLeastOneSymbol: "Трябва да съдържа поне 1 специален символ",
                minlength: "Трябва да съдържа поне 8 символа" ,
                maxlength: "Трябва да съдържа не повече от 50 символа",
                
            },
            passwordCheck:{ 
                // passWordValidationUpper: "Поне един главен символ",
                required: "полето е задължително",
                equalTo: 'паролите не съвпадат',
            },
            phoneNumber: {
                minlength: 'Номерът не е валиден',
                maxlength: 'Номеръ не е валиден',
                onlyNumbers: "Само Цифри",
                required: "Полето е задължително",
            },
            Email: {
                required : "Полето е задължително",
                isMailValid : "Моля въведете валиден мейл адрес",
            },
            adress: {
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            addrArea: { 
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            addrCity: { 
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            addrNeibr: { 
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            hiddenRecaptcha: {
                required: "Рекаптча кодът е задължителен",
                remote: "Рекаптча кодът трябва да се попълни отново",
            }
    }    

    })
});

$(document).ready(function(){
    $("#resetPassword").validate({
        
        // За hidden input
        ignore: ".ignore",

    rules: {
        newPwd: {
            required: true,
            atLeastOneLowercaseLetter: true,
            atLeastOneUppercaseLetter: true,
            atLeastOneNumber: true,
            atLeastOneSymbol: true,
            minlength: 8,
            maxlength: 40

        },
        newPwdConfirm: {
            required: true,
            equalTo: newPwd,
        },
        pwd : {
            required: true,
        }
        
    },
    messages: {
        newPwd: {
                required: "полето е задължително",
                atLeastOneUppercaseLetter: "Трябва да съдържа поне 1 главна буква",
                atLeastOneLowercaseLetter: "Трябва да съдържа поне 1 малка буква",
                atLeastOneNumber: "Трябва да съдържа поне 1 цифра" ,
                atLeastOneSymbol: "Трябва да съдържа поне 1 специален символ",
                minlength: "Трябва да съдържа поне 8 символа" ,
                maxlength: "Трябва да съдържа не повече от 50 символа",
                
            },
        newPwdConfirm:{
            required: "полето е задължително",
            equalTo: 'паролите не съвпадат',
            },
        pwd: {
            required: "полето е задължително",
        }

        }
    })
});

$(document).ready(function(){
    $("#addNewAdress").validate({
    rules: {
        address:{
            required: true,
            minlength: 3,
            maxlength: 50,
            bulgarianLettersAndSymbols: true,
        },
        messages: {
            address: { 
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
                },
            }
        }
    })
});

$(document).ready(function(){
    $("#changeAdress").validate({
    rules: {
            adress: {
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addrArea:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addrCity:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addrNeibr:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            }
        },
        messages: {
                adress: { 
                    required : "Полето е задължително",
                    bulgarianLettersAndSymbols: "Само символи на кирлица",
                    minlength: "Трябва да съдържа поне 5 символа",
                    maxlength: "Трябва да съдържа най-много 50 символа",
                    },
                addrArea: {
                    required : "Полето е задължително",
                    bulgarianLettersAndSymbols: "Само символи на кирлица",
                    minlength: "Трябва да съдържа поне 5 символа",
                    maxlength: "Трябва да съдържа най-много 50 символа",
                },
                addrCity:{
                    required : "Полето е задължително",
                    bulgarianLettersAndSymbols: "Само символи на кирлица",
                    minlength: "Трябва да съдържа поне 5 символа",
                    maxlength: "Трябва да съдържа най-много 50 символа",
                },
                addrNeibr:{
                    required : "Полето е задължително",
                    bulgarianLettersAndSymbols: "Само символи на кирлица",
                    minlength: "Трябва да съдържа поне 5 символа",
                    maxlength: "Трябва да съдържа най-много 50 символа",
                },
            }
    })
});

$(document).ready(function(){
    $("#addAdress").validate({
    rules: {
            addNewAdres: {
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addAddrArea:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addAddrCity:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            },
            addAddrNeibr:{
                required: true,
                minlength: 3,
                maxlength: 50,
                bulgarianLettersAndSymbols: true,
            }
        },
    messages: {
            addNewAdres: { 
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
                },
            addAddrArea: {
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            addAddrCity:{
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            addAddrNeibr:{
                required : "Полето е задължително",
                bulgarianLettersAndSymbols: "Само символи на кирлица",
                minlength: "Трябва да съдържа поне 5 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
        }
    })
});

$(document).ready(function(){
    $("#changeProfileInfo").validate({
        
        // За hidden input
        // ignore: ".ignore",

    rules: {
        username:{
            required: true,
            minlength: 3,
            maxlength: 50,
        },
        userFamName:{
            required: true,
            minlength: 3,
            maxlength: 50,
        },
        phoneNumber: {
            minlength: 10,
            maxlength: 13,
            onlyNumbers:true,
            required: true,
        },
        Email: {
            required: true,
            isMailValid : true,
        },
    }, 
    messages: {
            username:{
                required:  "Полето е задължително",
                minlength: "Трябва да съдържа поне 3 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            userFamName:{
                required:  "Полето е задължително",
                minlength: "Трябва да съдържа поне 3 символа",
                maxlength: "Трябва да съдържа най-много 50 символа",
            },
            phoneNumber: {
                minlength: 'Номерът не е валиден',
                maxlength: 'Номеръ не е валиден',
                onlyNumbers: "Само Цифри",
                required: "Полето е задължително",
            },
            Email: {
                required : "Полето е задължително",
                isMailValid : "Моля въведете валиден мейл адрес",
            }
    }    

    })
});


// var validator = $("#signupform").validate({
//     rules: {
//         firstname: "required",
//         lastname: "required",
//         username: {
//             required: true,
//             minlength: 2,
//             remote: "users.php"
//         }
//     },
//     messages: {
//         firstname: "Enter your firstname",
//         lastname: "Enter your lastname",
//         username: {
//             required: "Enter a username",
//             minlength: jQuery.format("Enter at least {0} characters"),
//             remote: jQuery.format("{0} is already in use")
//         }
//     }
// });

</script>

  <style>

  

material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;

  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;

  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;

  /* Support for IE. */
  font-feature-settings: 'liga';
}

.imageContainer {
    position: relative;
    width: 15%;
    display: inline-block;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%)
}

.imageContainer:hover .image {
  opacity: 0.3;
}

.imageContainer:hover .middle {
  opacity: 1;
}



.dropzone {
    position: relative;
    width: 330px;
    margin: auto;
    height: 330px;
    border: 4px dashed #ddd;
    background: #f6f6f6;
    margin-top: 85px;
}

.dropzone .dz-preview {
    height: 250px;
    width: 250px;
}

.dropzone .dz-preview .dz-image img {
    width: 250px;
    height: 250px;
}

.dropzone .dz-preview .dz-image {
    width: 250px;
    height: 250px;
}
/** Preview of collections of uploaded documents **/


/*media queries*/

@media only screen and (max-width: 601px){
  .fileuploader {
    width: 100%;
  }

 .preview-container {
    width: 100%;
  }
}










#main-menu li {
border-right: 1px solid #ffffff;
}
#main-menu li:last-child {
border-right: none
}

#login {
    padding-top: 50px
}
#login .form-wrap {
    width: 50%;
    margin: 0 auto;
}
#login h1 {
    color: #1fa67b;
    font-size: 18px;
    text-align: center;
    font-weight: bold;
    padding-bottom: 20px;
}
#login .form-group {
    margin-bottom: 25px;
}
#login .checkbox {
    margin-bottom: 20px;
    position: relative;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}
#login .checkbox.show:before {
    content: '\e013';
    color: #1fa67b;
    font-size: 17px;
    margin: 1px 0 0 3px;
    position: absolute;
    pointer-events: none;
    font-family: 'Glyphicons Halflings';
}
#login .checkbox .character-checkbox {
    width: 25px;
    height: 25px;
    cursor: pointer;
    border-radius: 3px;
    border: 1px solid #ccc;
    vertical-align: middle;
    display: inline-block;
}
#login .checkbox .label {
    color: #6d6d6d;
    font-size: 13px;
    font-weight: normal;
}
#login .btn.btn-custom {
    font-size: 14px;
	margin-bottom: 20px;
}
#login .forget {
    font-size: 13px;
	text-align: center;
	display: block;
} 

.body{
padding-bottom:60px;
}

.footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  background-color: #efefef;
  text-align: center;
  
}

#capatcha {
    margin: 0 auto;
    display: block;
    width: 30%;
}

arrow {
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}


.up {
    transform: rotate(-135deg);
    -webkit-transform: rotate(-135deg);
}

.down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
}

.valid{
    background-color:#89de89;
}
.alert {
  display: none;
}
.error {
  color: #e74c3c;
  background: white;
}

.container {
  margin-top: 20px;
}

.panel-heading {
  font-size: larger;
}



  .pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
}

/* Style the active/current link */
.pagination a.active {
    background-color: dodgerblue;
    color: white;
}

/* Add a grey background color on mouse-over */
.pagination a:hover:not(.active) {background-color: #ddd;}
 

  </style>

       <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    


  </head>
        <body>
        
        <?php  
        include '/navigation.php';
        ?>