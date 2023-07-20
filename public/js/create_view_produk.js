
function previewImage1() {
    const image1 = document.querySelector('#gmb');
    const imgPreview1 = document.querySelector('#img-preview');
  
    if (image1.files.length > 0 && image1.files[0]) {
      // User memilih file gambar
      const blob1 = URL.createObjectURL(image1.files[0]);
      imgPreview1.src = blob1;
    } else {
      // User tidak memilih file gambar
      imgPreview1.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
    }
  }


function previewImage2(){
//image 2
const image2 = document.querySelector('#gmb2');
const imgPreview2 = document.querySelector('#img-preview2');

if (image2.files.length > 0 && image2.files[0]) {
    // User memilih file gambar
    const blob2 = URL.createObjectURL(image2.files[0]);
    imgPreview2.src = blob2;
  } else {
    // User tidak memilih file gambar
    imgPreview2.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage3(){
//image 3
const image3 = document.querySelector('#gmb3');
const imgPreview3 = document.querySelector('#img-preview3');

if (image3.files.length > 0 && image3.files[0]) {
    // User memilih file gambar
    const blob3 = URL.createObjectURL(image3.files[0]);
    imgPreview3.src = blob3;
  } else {
    // User tidak memilih file gambar
    imgPreview3.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage4(){
//image 4
const image4 = document.querySelector('#gmb4');
const imgPreview4 = document.querySelector('#img-preview4');

if (image4.files.length > 0 && image4.files[0]) {
    // User memilih file gambar
    const blob4 = URL.createObjectURL(image4.files[0]);
    imgPreview4.src = blob4;
  } else {
    // User tidak memilih file gambar
    imgPreview4.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage5(){
//image 5
const image5 = document.querySelector('#gmb5');
const imgPreview5 = document.querySelector('#img-preview5');

if (image5.files.length > 0 && image5.files[0]) {
    // User memilih file gambar
    const blob5 = URL.createObjectURL(image5.files[0]);
    imgPreview5.src = blob5;
  } else {
    // User tidak memilih file gambar
    imgPreview5.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage6(){
//image 6
const image6 = document.querySelector('#gmb6');
const imgPreview6 = document.querySelector('#img-preview6');

if (image6.files.length > 0 && image6.files[0]) {
    // User memilih file gambar
    const blob6 = URL.createObjectURL(image6.files[0]);
    imgPreview6.src = blob6;
  } else {
    // User tidak memilih file gambar
    imgPreview6.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage7(){
//image 7
const image7 = document.querySelector('#gmb7');
const imgPreview7 = document.querySelector('#img-preview7');

if (image7.files.length > 0 && image7.files[0]) {
    // User memilih file gambar
    const blob7 = URL.createObjectURL(image7.files[0]);
    imgPreview7.src = blob7;
  } else {
    // User tidak memilih file gambar
    imgPreview7.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}

function previewImage8(){
//image 8
const image8 = document.querySelector('#gmb8');
const imgPreview8 = document.querySelector('#img-preview8');

if (image8.files.length > 0 && image8.files[0]) {
    // User memilih file gambar
    const blob8 = URL.createObjectURL(image8.files[0]);
    imgPreview8.src = blob8;
  } else {
    // User tidak memilih file gambar
    imgPreview8.src = '/imgs/plus.png'; // Mengganti gambar dengan placeholder
  }
}



//###########################################
$(document).ready(function(){
    
    $('#add1').click(function(){
         $('#gambar_produk2').show('slow')
         $('#gmb2').prop('disabled' , false)
       
             $('#del2').click(function(){
                 $('#gambar_produk2').hide('slow')
                 $('#gmb2').prop('disabled' , true)
                 $('#gmb2').val('')
                 $('#img-preview2').attr('src' , '/imgs/plus.png')
             })
     })

     $('#add2').click(function(){
         $('#gambar_produk3').show('slow')
         $('#gmb3').prop('disabled' , false)
             $('#del3').click(function(){
                 $('#gambar_produk3').hide('slow')
                 $('#gmb3').prop('disabled' , true)
                 $('#gmb3').val('')
                 $('#img-preview3').attr('src' , '/imgs/plus.png')
             })
     })
     
     $('#add3').click(function(){
         $('#gambar_produk4').show('slow')
         $('#gmb4').prop('disabled' , false)
             $('#del4').click(function(){
                 $('#gambar_produk4').hide('slow')
                 $('#gmb4').prop('disabled' , true)
                 $('#gmb4').val('')
                 $('#img-preview4').attr('src' , '/imgs/plus.png')
             })
     })

     $('#add4').click(function(){
         $('#gambar_produk5').show('slow')
         $('#gmb5').prop('disabled' , false)
             $('#del5').click(function(){
                 $('#gambar_produk5').hide('slow')
                 $('#gmb5').prop('disabled' , true)
                 $('#gmb5').val('')
                 $('#img-preview5').attr('src' , '/imgs/plus.png')
             })
     })

     $('#add5').click(function(){
         $('#gambar_produk6').show('slow')
         $('#gmb6').prop('disabled' , false)
             $('#del6').click(function(){
                 $('#gambar_produk6').hide('slow')
                 $('#gmb6').prop('disabled' , true)
                 $('#gmb6').val('')
                 $('#img-preview6').attr('src' , '/imgs/plus.png')
             })
     })

     $('#add6').click(function(){
         $('#gambar_produk7').show('slow')
         $('#gmb7').prop('disabled' , false)
             $('#del7').click(function(){
                 $('#gambar_produk7').hide('slow')
                 $('#gmb7').prop('disabled' , true)
                 $('#gmb7').val('')
                 $('#img-preview7').attr('src' , '/imgs/plus.png')
             })
     })

     $('#add7').click(function(){
         $('#gambar_produk8').show('slow')
         $('#gmb8').prop('disabled' , false)
             $('#del8').click(function(){
                 $('#gambar_produk8').hide('slow')
                 $('#gmb8').prop('disabled' , true)
                 $('#gmb8').val('')
                 $('#img-preview8').attr('src' , '/imgs/plus.png')
             })
     })
     
 })