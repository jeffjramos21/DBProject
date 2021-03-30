
//AOS fade up functions
!(function($) {
  "use strict";
  
  // Init AOS
  function aos_init() {
    AOS.init({
      duration: 1000,
      once: true
    });
  }
  $(window).on('load', function() {
    aos_init();
  });

})(jQuery);


//Student Search RSO Function
function searchRSO() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function editComment(){
  $('#editModal').modal('show');
}

function closeEdit(){
  $('#editModal').modal('hide');
}

function removeComment(){
  $('#removeModal').modal('show');
}

function closeRemove(){
  $('#removeModal').modal('hide');
}

function showRating(stars) {
  if (stars == 1) {
      return '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star-o"></i></span>' +
          '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>'
  }
  else if (stars == 2) {
      return '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star-o"></i></span>' +
          '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>'
  }
  else if (stars == 3) {
      return '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star-o"></i></span>' +
          '<span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>'
  }
  else if (stars == 4) {
      return '<span class="float-right"><i class="text-warning fa fa-star-o"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>' +
          '<span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>'
  }
  if (stars == 5) {
      return '<span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>' +
          '<span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span><span class="float-right"><i class="text-warning fa fa-star"></i></span>'
  }
}