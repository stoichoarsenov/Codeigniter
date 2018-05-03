<?php
$this->load->library('session');
?>
<html>
        <head>
                <title>CodeIgniter</title>
                <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
  
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
    return this.optional(element) || /^[0-9 .]+$/i.test(value);
});

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
        minlength: 5,
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
</script>

  <style>




footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  background-color: #efefef;
  text-align: center;
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
  
        </head>
        <body>
        
        <?php  
        include '/navigation.php';
        ?>