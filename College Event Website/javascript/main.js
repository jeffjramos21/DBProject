
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

var jcontent7 = {
  "ID": [0,1,2,3,4,5,6,7,8,9],
  "RSO": ["3D Printing and Design", "Biology Graduate Student Association", "Girl Up Orlando", "Holmes Scholars Program",
      "Latino Medical Student Association", "Modeling and Simulation Knights", "ONE at UCF", "Photonics Society",
      "Scientista", "Team Sport Business Management"],
  "Description": ["The mission of 3D-PaD is to make 3D printing and 3D design available to all students at UCF. We teach all skill levels the essentials of 3D modeling and printing and offer 3D printers for both academic and personal use.",
      "To provide opportunities for UCF biology students to participate in extracurricular activities in Biology.", "Girl Up Orlando is an organization that strives to empower students by channeling their energy and compassion to raise awareness for the United Nations initiatives that help hard to reach adolescent girls.",
      "The Holmes Scholars is organized for four primary purposes:To work toward the diversification of faculty and students in Schools and Colleges of Education and of K-12 teachers and administrators and to represent the interest and voices of the Holmes Scholars campus-wide.",
      "The Latino Medical Student Association at UCF unites and empowers pre-health students through service, mentorship and education to advocate for the health of the Latino community.",
      "MaSK (Modeling and Simulation Knights) is graduate student organization at UCF for students in the School of Modeling, Simulation, & Training and other related STEM fields to collaborate, network, and socialize within the organization and with other members of the simulation community.",
      "ONE at UCF Chapter advocates to end extreme poverty and preventable disease worldwide while bringing awareness and advocacy for aids and malaria in Sub-Saharan Africa.",
      "", "The mission of this organization is to empower women majoring in Science, Technology, Engineering, Mathematics, and Medicine (STEMM) by providing a strong campus community, online resources, and visible role models.",
      "Student Organization of the DeVos Sport Business Management Program."],
  "Admin": ["3dprinting@knights.ucf.edu", "biology@knights.ucf.edu", "girlup@knights.ucf.edu", "holmes@knights.ucf.edu", "latinomed@knights.ucf.edu", "modeling@knights.ucf.edu", "one@knights.ucf.edu",
      "photonics@knights.ucf.edu", "scientista@knights.ucf.edu", "sports@knights.ucf.edu"]
}

function selectRSO(rsoID){
  console.log(rsoID);
  for(var i = 0; i < jcontent7.ID.length; i++){
      if(jcontent7.ID[i] == rsoID){
        window.location.href="viewRSO.html";
        console.log("ID" + jcontent7.ID[i]);

          var RSO = document.getElementById("showRSO2");
          console.log("RSO:" + RSO);
          RSO.innerHTML = '<p><b>Description: </b>' + jcontent7.Description[i] + '</p><br/><p><b>Admin Contact Email: </b>' + jcontent7.Admin[i] + '</p>';
      
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