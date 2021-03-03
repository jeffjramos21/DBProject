
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


//Dynamically creating table rows and showing their RSOs
// var jcontent = {
//   "RSO": ["Advocates for World Health", "American Sign Language Club", "Anime Spot",
//             "Art Club", "Financial Knights Association"]
// }

// for(var i = 0; i < jcontent.RSO.length; i++) {
//   var table = document.getElementById("StudentRSOtable");
//   var row = table.insertRow(i+1);
//   var cell1 = row.insertCell(0);
//   var cell2 = row.insertCell(1);
//   cell1.innerHTML = i + 1;
//   cell2.innerHTML = jcontent.RSO[i];
// }


//Dynamically creating table rows and showing all existing RSOs
// var jcontent1 = {
//   "RSO": ["3D Printing and Design", "Biology Graduate Student Association","Girl Up Orlando","Holmes Scholars Program",
//           "Latino Medical Student Association", "Modeling and Simulation Knights", "ONE at UCF", "Photonics Society",
//         "Scientista","Team Sport Business Management"]
// }

// for(var i = 0; i < jcontent1.RSO.length; i++) {
//   var table = document.getElementById("myTable");
//   var row = table.insertRow(i+1);
//   var cell1 = row.insertCell(0);
//   cell1.innerHTML = jcontent1.RSO[i] + '<a href="#" class="btn">Join</a>';
// }


//Daily and Weekly Events
// jcontent2 = {
//   "EventTime": ["10:00 AM", "12:00PM", "12:00 PM", "3:00 PM", "6:00 PM"],
//   "EventName": ["Paper House - 2021 Annual MFA Exhibition", "EndNote Citation Management", "Application Workshop #2", "Preparing a Research Poster", "In Her Honor"],
//   "EventDescription": ["Paper House explores fragility, transparency, and validation of intimate relationships and experiences through a variety of mediums and processes. The exhibition showcases the thesis work of Master of Fine Arts candidates in the UCF School of Visual Arts and Design: Gabe Cortese, Danielle Culibao Powell, Tim Reid and Annette Tojar.",
//     "Citation management tools allow you to dedicate more time to research. Join us to learn how to export citations from library databases, organize citations, generate bibliographies and format citations in a Word document. EndNote can help make managing your references and formatting citations easy.",
//     "Join us for our second Zoom virtual workshop that will help you prepare your application for the 2021 Joust New Venture Competition presented by Viatek.",
//     "This workshop will help undergraduate students gain skills to prepare a poster presentation of your research or creative work. Note: This workshop is for students already working on a research project.",
//     "On Monday, March 1 from 6 to 7:30 p.m., join your community of peers from womxn based organizations for a night of honoring Womxnhood and Embracing Art. Come with your creative and diverse minds as we will be creating our own works of art in honor of Women's History Month."]
// }

// jcontent3 = {
//   "EventTime": ["9:00 AM","9:00 AM", "10:00 AM", "12:00 PM", "3:00 PM", "12:00 PM", "10:00 AM"],
//   "EventDate": ["February 29, 2021", "February 28, 2021", "March 01, 2021", "March 01, 2021", "March 02, 2021", "March 03, 2021", "March 04, 2021"],
//   "EventName": ["Kayaking Day Trip", "Scaramouch in Naxos","Paper House - 2021 Annual MFA Exhibition", "EndNote Citation Management", "Pride Chats", "Prep with a Pro","How to Start Your Business"],
//   "EventDescription": ["Join Outdoor Adventure as we paddle through Central Florida’s diverse wetlands. Kayaking offers the opportunity to connect with nature in a very unique way, and as we move through the rivers we will hopefully get to see plenty of wildlife like fish, turtles, and birds dive beneath the surface.",
//     "Full of raucous energy typical of Commedia dell’arte, this colorful play involves a plot by the roguish clown Scaramouch to have Bacchus, the Greek god himself, star in his latest theatrical piece.",
//   "Paper House explores fragility, transparency, and validation of intimate relationships and experiences through a variety of mediums and processes. The exhibition showcases the thesis work of Master of Fine Arts candidates in the UCF School of Visual Arts and Design: Gabe Cortese, Danielle Culibao Powell, Tim Reid and Annette Tojar.",
// "Citation management tools allow you to dedicate more time to research. Join us to learn how to export citations from library databases, organize citations, generate bibliographies and format citations in a Word document. EndNote can help make managing your references and formatting citations easy.",
// "Pride Chats are a biweekly discussion that focuses on a multitude of diverse topics. The topics are different at each event and address different aspects of the LGBTQ+ community.",
// "Join employers presenting on topics, including interviewing strategies, impressing the recruiter, financial check-up and more to help you prepare to launch your career.",
// "If you’re thinking of starting a business, it’s important to take the right steps. This course will give you an overview of what to know, actions to take, and how to avoid common missteps to give your company its greatest chance of success."]
// }

// for(var i = 0; i < jcontent3.EventName.length; i++){
//   var week = document.createElement('div');
//   week.id = "studentWeek";
//   document.getElementById('studentWeek').appendChild(week)
//   week.innerHTML = '<div class="row schedule-item"> <div class="col-md-2"><time>' + jcontent3.EventDate[i] + '</time>' + '<time>' + jcontent3.EventTime[i] + 
//   '</time></div><div class="col-md-10"><h4>'+ jcontent3.EventName[i] + '</h4><p>' + jcontent3.EventDescription[i] + '</p></div></div>';
// }

// for(var i = 0; i < jcontent2.EventName.length; i++){
//   var day = document.createElement('div');
//   day.id = "studentDay";
//   document.getElementById('studentDay').appendChild(day)
//   day.innerHTML = '<div class="row schedule-item"> <div class="col-md-2"><time>' + jcontent2.EventTime[i] +
//   '</time></div><div class="col-md-10"><h4>'+ jcontent2.EventName[i] + '</h4><p>' + jcontent2.EventDescription[i] + '</p></div></div>';
// }


//Pending Events
// jcontent4 = {
//   "EventName": ["Knights Write 2021", "Yoga and Hiking", "PokeKnights: Virtual Club Meetings"],
//   "Date": ["2/24/2021", "2/22/2021", "2/22/2021"],
//   "Time": ["10:30 AM", "8:00 AM", "5:00 PM"],
//   "Location": ["Virtual", "Lake Claire Recreational Area", "Virtual"],
//   "EventType": ["Public", "Public", "RSO"],
//   "EventCat": ["Academic", "Recreation & Exercise", "Social Event"],
//   "Phone": ["407-823-2000", "407-823-2001", "407-823-2002"],
//   "Email": ["event1@knights.ucf.edu", "event2@knights.ucf.edu", "event3@knights.ucf.edu"],
//   "Description": ["This three-day virtual event celebrates outstanding writing and research by UCFstudents in ENC 1101 and 1102 and upper-division and graduate programs' writing and rhetoric courses.Knights Write 2021 spotlights the transformative nature of the first-year writing program at UCF forstudents from across the university and the powerful impact of advanced rhetorical study on students’research and writing abilities.",
//     "Lake Claire’s sandy shore is the best place on campus for a relaxing introduction toyoga! This is a great opportunity for you to learn about yoga,or have a great time with us even if you’re an experienced yogi! After a refreshing yoga session, we’llgo explore some of the incredible nature trails on campus and enjoy avery peaceful morning together!",
//     "Join us for fun Pokemon-themed activities online from the comfort and safety of yourhome. Open to all."
//   ]
// }

// for(var i = 0; i < jcontent4.EventName.length; i++){
//   var pending = document.createElement('div');
//   pending.id = "accordion";
//   document.getElementById('accordion').appendChild(pending)
//   pending.innerHTML = '<div class="card"><div class="card-header"><h5 class="mb-0"><button class="btn">' +
//   jcontent4.EventName[i] + '</button></h5></div><div data-parent="#accordion"><div class="card-body"><b>Date: </b>' + jcontent4.Date[i] + 
//   '<br /><b>Time: </b>' + jcontent4.Time[i] + '<br /><b>Location: </b>' + jcontent4.Location[i] + '<br /><b>Event Type: </b>' + jcontent4.EventType[i] + '<br /><b>Event Category: </b>' + jcontent4.EventCat[i] +
//   '<br /><b>Contact Phone Number: </b>' + jcontent4.Phone[i] + '<br /><b>Contact E-mail: </b>' + jcontent4.Email[i] + '<br /><b>Description: </b>' + jcontent4.Description[i] + 
//   '<div class="decisionbuttons"><a href="#" class="btnapprove">Approve</a><a href="#" class="btndeny">Deny</a></div></div></div></div>'
// }