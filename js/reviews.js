// var hostname = "https://wooshark.website";

// jQuery(document).on("click", "#openModalReviews", function(event) {
//     // window.open("https://www.wooshark.com/aliexpress");
// });



// jQuery('#enableImagePreference').click(function() {
//     if (jQuery('#enableImagePreference').is(':checked')) {
//         jQuery('.enableImagePreferenceDisplay').show();
//     } else {
//         jQuery('.enableImagePreferenceDisplay').hide();
//     }
// });


// jQuery('#enableAddTExt').click(function() {
//     if (jQuery('#enableAddTExt').is(':checked')) {
//         jQuery('.enableAddTExtDisplay').show();
//     } else {
//         jQuery('.enableAddTExtDisplay').hide();
//     }
// });


// jQuery('#enableImageHover').click(function() {
//     if (jQuery('#enableImageHover').is(':checked')) {
//         jQuery('.enableImageHoverDisplay').show();
//     } else {
//         jQuery('.enableImageHoverDisplay').hide();
//     }
// });


// var p1 = 'hello test is ok';
// jQuery(document).on("click", "#addReview", function(event) {
//     console.log("hndle ui-sortable-handle", jQuery(".wp-heading-inline"));
//     event.preventDefault();
//     jQuery("#table-reviews tbody").append(
//         '<tr><td style="width:60%" contenteditable>  review content  </td><td contenteditable style="width:15%">' +
//         getUsername() +
//         '</td><td contenteditable style="width:15%">' +
//         new Date().toISOString().slice(0, 10) +
//         '</td></td><td style="width:10%"><input style="width:100%" type="number" min="1" max="5" value="5"></td><td><button class="btn btn-danger" id="removeReview">X</button></td></tr>'
//     );
//     jQuery("#table-reviews tr td[contenteditable]").css({
//         border: "1px solid #51a7e8",
//         "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
//     });
// });

// jQuery(document).on("click", "#FillTenReviews", function(event) {
//     event.preventDefault();

//     for (var i = 0; i < 10; i++) {
//         jQuery("#table-reviews tbody").append(
//             '<tr><td style="width:60%" contenteditable>  review content  </td><td contenteditable style="width:15%">' +
//             getUsername() +
//             '</td><td contenteditable style="width:15%">' +
//             new Date().toISOString().slice(0, 10) +
//             '</td></td><td style="width:10%"><input style="width:100%" type="number" min="1" max="5" value="5"></td><td><button class="btn btn-danger" id="removeReview">X</button></td></tr>'
//         );
//         jQuery("#table-reviews tr td[contenteditable]").css({
//             border: "1px solid #51a7e8",
//             "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
//         });
//     }
// });

// var scaleValue = 1;

// jQuery(document).on("click", "#zoom-in", function() {
//     console.log("----------------zoom-out");
//     // jQuery('div.carousel-item.active').width(jQuery('div.carousel-item.active').width() * 1.2)
//     scaleValue = scaleValue * 1.2;
//     jQuery("div.carousel-item.active").css({
//         "-webkit-transform": "scale(" + scaleValue + ")",
//         "-moz-transform": "scale(" + scaleValue + ")",
//         "-ms-transform": "scale(" + scaleValue + ")",
//         "-o-transform": "scale(" + scaleValue + ")",
//         transform: "scale(" + scaleValue + ")"
//     });
// });

// jQuery(document).on("click", "#zoom-out", function() {
//     scaleValue = scaleValue * 0.9;

//     // jQuery('div.carousel-item.active').width(jQuery('div.carousel-item.active').width() * 0.5)
//     jQuery("div.carousel-item.active").css({
//         "-webkit-transform": "scale(" + scaleValue + ")",
//         "-moz-transform": "scale(" + scaleValue + ")",
//         "-ms-transform": "scale(" + scaleValue + ")",
//         "-o-transform": "scale(" + scaleValue + ")",
//         transform: "scale(" + scaleValue + ")"
//     });
// });

// var rotateValue = 0;
// jQuery(document).on("click", "#rotateClock", function() {
//     if (rotateValue < 360) {
//         rotateValue = rotateValue + 90;

//         // jQuery('div.carousel-item.active').width(jQuery('div.carousel-item.active').width() * 0.5)
//         jQuery("div.carousel-item.active").css({
//             "-webkit-transform": "rotate(" + rotateValue + "deg)",
//             "-moz-transform": "rotate(" + rotateValue + "deg)",
//             "-ms-transform": "rotate(" + rotateValue + "deg)",
//             "-o-transform": "rotate(" + rotateValue + "deg)",
//             transform: "rotate(" + rotateValue + "deg)"
//         });
//     }
// });

// jQuery(document).on("click", "#rotateleft", function() {
//     if (rotateValue > -360) {
//         rotateValue = rotateValue - 90;

//         // jQuery('div.carousel-item.active').width(jQuery('div.carousel-item.active').width() * 0.5)
//         jQuery("div.carousel-item.active").css({
//             "-webkit-transform": "rotate(" + rotateValue + "deg)",
//             "-moz-transform": "rotate(" + rotateValue + "deg)",
//             "-ms-transform": "rotate(" + rotateValue + "deg)",
//             "-o-transform": "rotate(" + rotateValue + "deg)",
//             transform: "rotate(" + rotateValue + "deg)"
//         });
//     }
// });

// function forceDownload(url, fileName) {
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", url, true);
//     xhr.responseType = "blob";
//     xhr.onload = function() {
//         var urlCreator = window.URL || window.webkitURL;
//         var imageUrl = urlCreator.createObjectURL(this.response);
//         var tag = document.createElement("a");
//         tag.href = imageUrl;
//         tag.download = fileName;
//         document.body.appendChild(tag);
//         tag.click();
//         document.body.removeChild(tag);
//     };
//     xhr.send();
// }

// jQuery(document).on("click", "#download", function() {
//     forceDownload(
//         jQuery("div.carousel-item.active img").attr("src"),
//         "image.png"
//     );
// });


// jQuery(document).on("click", "#closeModal", function() {
//     // jQuery('#myModal').close()

// });

// jQuery(document).on("click", "#full-screen", function() {
//     var elem = document.documentElement;

//     /* View in fullscreen */
//     function openFullscreen() {
//         if (elem.requestFullscreen) {
//             elem.requestFullscreen();
//         } else if (elem.mozRequestFullScreen) {
//             /* Firefox */
//             elem.mozRequestFullScreen();
//         } else if (elem.webkitRequestFullscreen) {
//             /* Chrome, Safari and Opera */
//             elem.webkitRequestFullscreen();
//         } else if (elem.msRequestFullscreen) {
//             /* IE/Edge */
//             elem.msRequestFullscreen();
//         }
//     }

//     openFullscreen();
// });

// // alert(my_options);



// function displayAdvanced() {

//     jQuery('#myModal').remove()
//     jQuery(
//         '<div class="modal fade" id="myModal" role="dialog">' +
//         '<div class="modal-dialog" style="min-width: 1023px;height: 0%;">' +
//         '   <div class="modal-content" style="height: 100%;">' +
//         '      <div class="modal-body"  id="contentImage">' +
//         '<div class="top-menu-bar row">' +
//         // '<div class="col-6" id="counter">    </div>' +
//         '<div class="col-12 d-flex justify-content-start align-items-center">' +
//         '<button  id="zoom-in" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-search-plus fa-2x " ></i></button>' +
//         '<button  id="zoom-out" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-search-minus fa-2x " ></i></button>' +
//         '<button  id="full-screen" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-compress fa-2x " ></i></button>' +
//         '<button  id="rotateClock" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-redo fa-2x"></i></button>' +
//         '<button  id="rotateleft" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-undo fa-2x " ></i></button>' +
//         '<button  id="download" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-download fa-2x" ></i></button>' +

//         '<button  id="close" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary" data-dismiss="modal">' +
//         ' <i class="fa fa-window-close fa-2x" aria-hidden="true"></i></button>' +
//         "</div>" +
//         "</div>" +
//         '<div class="w3-row-padding w3-margin-top">' +
//         "</div>" +
//         " </div>" +
//         "</div>" +
//         "</div>"
//     ).appendTo("html");
//     var images = jQuery(".woocommerce-product-gallery__wrapper img");
//     for (var i = 0; i < images.length + 1; i++) {
//         // imagesSrc.push(images[i].attr('src'))
//         if (images[i]) {
//             var image = images[i].src;
//             var currentIndex = i + 1;
//             jQuery(
//                 '<div class="w3-third">' +
//                 '<div class="w3-card">' +
//                 '<img src="' + image + '" style="width:100%">' +
//                 '<div class="w3-container">' +
//                 '<h5>5 Terre</h5>' +
//                 '</div>' +
//                 '</div>' +
//                 '</div>'
//             ).appendTo(".w3-row-padding");
//         }
//     }
//     var addTextContent = '';
//     var selectedOption = "";
//     try {
//         sliderConfiguration = localStorage.getItem("sliderConfiguration") ?
//             JSON.parse(localStorage.getItem("sliderConfiguration")) :
//             false;
//     } catch (e) {
//         console.log('e', e);
//     } finally {
//         jQuery("#myModal").modal();
//     }
// }


// function displayCarousel() {

//     jQuery('#myModal').remove()
//     jQuery(
//         '<div class="modal fade" id="myModal" role="dialog">' +
//         '<div class="modal-dialog" style="min-width: 1023px;height: 0%;">' +
//         '   <div class="modal-content" style="height: 100%;">' +
//         '      <div class="modal-body"  id="contentImage">' +
//         '<div class="top-menu-bar row">' +
//         // '<div class="col-6" id="counter">    </div>' +
//         '<div class="col-12 d-flex justify-content-start align-items-center">' +
//         '<button  id="zoom-in" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-search-plus fa-2x " ></i></button>' +
//         '<button  id="zoom-out" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-search-minus fa-2x " ></i></button>' +
//         '<button  id="full-screen" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-compress fa-2x " ></i></button>' +
//         '<button  id="rotateClock" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-redo fa-2x"></i></button>' +
//         '<button  id="rotateleft" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-undo fa-2x " ></i></button>' +
//         '<button  id="download" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary">' +
//         ' <i class="fa fa-download fa-2x" ></i></button>' +

//         '<button  id="close" style="background-color:#5a6877; min-width: 70px; margin-right:5px; border-radius:7px" class="btn btn-primary" data-dismiss="modal">' +
//         ' <i class="fa fa-window-close fa-2x" aria-hidden="true"></i></button>' +

//         // '<button  id="rotateleft" style="background-color:#5a6877; min-width: 70px; margin:5px" class="btn btn-primary">' +
//         // ' <i class="fa fa-undo" fa-2x ></i></button>' +

//         "</div>" +
//         "</div>" +
//         ' <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">' +
//         ' <ol class="carousel-indicators">' +
//         " </ol>" +
//         ' <div class="carousel-inner" style="    height: 83vh;">' +
//         '  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" ' +
//         ' data-slide="prev">' +
//         '  <span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
//         '   <span class="sr-only">Previous</span>' +
//         " </a>" +
//         ' <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"' +
//         'data-slide="next">' +
//         '   <span class="carousel-control-next-icon" aria-hidden="true"></span>' +
//         ' <span class="sr-only">Next</span>' +
//         "  </a>" +
//         " </div>" +
//         "     </div>" +
//         " </div>" +
//         "</div>" +
//         "</div>"
//     ).appendTo("html");



//     // } finally {

//     var images = jQuery(".woocommerce-product-gallery__wrapper img");
//     for (var i = 0; i < images.length + 1; i++) {
//         // imagesSrc.push(images[i].attr('src'))
//         if (images[i]) {
//             var image = images[i].src;
//             var currentIndex = i + 1;
//             // jQuery('#counter').html('<span>' + currentIndex + '/' + images.length + '</span>')

//             if (i == 0) {
//                 jQuery(
//                     '<li data-target="#carouselExampleIndicators" data-slide-to="' +
//                     i +
//                     '" class="active"></li>'
//                 ).appendTo(".carousel-indicators");
//             } else {
//                 jQuery(
//                     '<li data-target="#carouselExampleIndicators" data-slide-to="' +
//                     i +
//                     '" class=""></li>'
//                 ).appendTo(".carousel-indicators");
//             }
//             if (i == 0) {
//                 jQuery(
//                     '<div class="carousel-item active">' +
//                     '    <img class="d-block w-100" src="' +
//                     image +
//                     '" alt="First slide">' +
//                     '<div class="add-text-content" style="position:absolute; top:  20px; font-size:30px; font-family: fantasy; right: 20px;background-color: transparent;color: grey;padding-left: 20px;padding-right: 20px;"></div>' +
//                     "   </div>"
//                 ).appendTo(".carousel-inner");
//             } else {
//                 jQuery(
//                     '<div class="carousel-item">' +
//                     '    <img class="d-block w-100" src="' +
//                     image +
//                     '" alt="First slide">' +
//                     '<div class="add-text-content" style="position:absolute; top:  20px; font-size:30px; font-family: fantasy; right: 20px;background-color: transparent;color: grey;padding-left: 20px;padding-right: 20px;"></div>' +
//                     "   </div>"
//                 ).appendTo(".carousel-inner");
//             }
//         }
//     }


//     var addTextContent = '';
//     var selectedOption = "";

//     try {
//         sliderConfiguration = localStorage.getItem("sliderConfiguration") ?
//             JSON.parse(localStorage.getItem("sliderConfiguration")) :
//             false;

//         // array('imagePreference' =>$savedValue1['imagePreference'],
//         //  'textToAddContent' =>$savedValue2['textToAddContent'],
//         //  'pw_script_vars.positionText' =>$savedValue3['positionText'],
//         //  'hoverPreference' =>$savedValue4['hoverPreference']));


//         console.log('---------', pw_script_vars);
//         if (pw_script_vars && pw_script_vars.imagePreference) {

//             if (pw_script_vars.imagePreference == "isRounded") {
//                 jQuery(".carousel-inner").css({ "border-radius": "15px" });
//             } else if (pw_script_vars.imagePreference == "isThumb") {
//                 jQuery(".carousel-inner").css({
//                     border: "1px solid #ddd",
//                     "border-radius": "4px",
//                     padding: "5px"
//                 });
//             } else if (pw_script_vars.imagePreference == "isCircle") {
//                 jQuery(".carousel-inner").css({ "border-radius": "50%" });
//             }
//         }

//         if (pw_script_vars && pw_script_vars.textToAddContent) {
//             addTextContent = pw_script_vars.textToAddContent;
//             jQuery("div.add-text-content").append(addTextContent);
//         }


//         if (pw_script_vars && pw_script_vars.hoverPreference == 'isGreyed') {
//             jQuery(".carousel-inner").addClass('w3-hover-grayscale');
//         }

//         if (pw_script_vars && pw_script_vars.hoverPreference == 'isOpacity') {
//             jQuery(".carousel-inner").addClass('w3-hover-opacity');
//         }

//         if (pw_script_vars && pw_script_vars.hoverPreference == 'isSepia') {
//             jQuery(".carousel-inner").addClass('w3-hover-sepia');
//         }





//     } catch (e) {
//         console.log('e', e);

//     } finally {

//         // setTimeout(function() {
//         jQuery("#myModal").modal();
//         // }, 2000);
//     }
//     // }

// }

// jQuery(document).ready(function() {

//     jQuery(document).on("click", ".woocommerce-product-gallery__image", function(
//         event
//     ) {
//         displayCarousel();


//     });
// });

// jQuery(document).on("click", "#testdom", function(event) {
//     console.log("----", jQuery(".product_title"));
// });

// jQuery(document).on("click", "#removeReview", function(event) {
//     jQuery(this)
//         .parents("tr")
//         .remove();
// });

// // jQuery(document).on("click", "#saveConfigurationSlider", function(event) {
// //     var sliderConfiguration = {
// //         selectedOption: jQuery("input[name=option2]:checked").val(),
// //         addTextContent: jQuery('#addTextContent').val()
// //     };
// //     console.log("-----------", sliderConfiguration.selectedOption);

// //     localStorage.setItem("sliderConfiguration", JSON.stringify(sliderConfiguration));
// // });

// jQuery(document).on("click", "#FillTwentyReviews", function(event) {
//     for (var i = 0; i < 20; i++) {
//         jQuery("#table-reviews tbody").append(
//             '<tr><td style="width:60%" contenteditable>  review content  </td><td contenteditable style="width:15%">' +
//             getUsername() +
//             '</td><td contenteditable style="width:15%">' +
//             new Date().toISOString().slice(0, 10) +
//             '</td></td><td style="width:10%"><input style="width:100%" type="number" min="1" max="5" value="5"></td><td><button class="btn btn-danger" id="removeReview">X</button></td></tr>'
//         );
//         jQuery("#table-reviews tr td[contenteditable]").css({
//             border: "1px solid #51a7e8",
//             "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
//         });
//     }
// });

// jQuery(document).on("click", "#confirmReviewInsertion", function(event) {
//     event.preventDefault();
//     var reviews = getReviews();
//     var url = window.location.href;
//     var indexStartPostID = url.indexOf("?post=");
//     var indexEndPostId = url.indexOf("&");
//     var postId = url.substring(indexStartPostID + 6, indexEndPostId);
//     console.log("---------reviews", reviews);
//     console.log("---------postId", postId);
//     insertReviewsIntoWordpress(reviews, postId);
// });

// function getReviews() {
//     var trs = $("#customReviews tr");
//     var reviews = [];
//     _.each(trs, function(item, index) {
//         if (index) {
//             reviews.push({
//                 review: item.cells[0].innerHTML || "-",
//                 rating: $(item)
//                     .find("input")
//                     .val() || 5,
//                 datecreation: item.cells[2].outerText,
//                 username: item.cells[1].outerText || "unknown"
//             });
//         }
//     });
//     return reviews;
// }

// function insertReviewsIntoWordpress(reviews, postId) {
//     var website, key_client, sec_client;

//     website = localStorage.getItem("website");
//     key_client = localStorage.getItem("key_client");
//     sec_client = localStorage.getItem("sec_client");

//     if (website && key_client && sec_client) {
//         jQuery(".loader2").css({
//             display: "block",
//             position: "fixed",
//             "z-index": 9999,
//             top: "50px",
//             right: "50px",
//             "border-radius": "35px",
//             "background-color": "black"
//         });
//         xmlhttp = new XMLHttpRequest();
//         xmlhttp.onreadystatechange = function() {
//             if (xmlhttp.readyState == 4) {
//                 var responseWoocomerce = xmlhttp.status;

//                 handleServerResponse(responseWoocomerce);
//                 if (responseWoocomerce === 200) {
//                     if (xmlhttp.response) {
//                         try {
//                             // location.reload();
//                         } catch (e) {
//                             // displayToast('Internal server Error', 'red');
//                         }
//                     }
//                 }
//             }
//         };

//         xmlhttp.open("POST", hostname + ":8002/addReviews", true);
//         xmlhttp.setRequestHeader("Content-Type", "application/json");
//         xmlhttp.send(
//             JSON.stringify({
//                 reviews: reviews,
//                 productIdFromWoocommerce: postId,
//                 clientWebsite: website,
//                 clientKey: key_client,
//                 clientSecretKey: sec_client
//             })
//         );
//     } else {
//         displayToast(
//             "You are not connected to your shop, please go to the plugin page and connect to your shop",
//             "red"
//         );
//     }
// }

// function getCreationDate(date) {
//     var date = dates[Math.floor(Math.random() * dates.length)];
//     var nameIndex = dates.indexOf(date);
//     dates.splice(nameIndex, 1);
//     return date;
// }

// function getUsername() {
//     var name = names[Math.floor(Math.random() * names.length)];
//     var nameIndex = names.indexOf(name);
//     names.splice(nameIndex, 1);
//     return name;
// }

// var names = [
//     "Craig Piro",
//     "Cindi Mcfarlin",
//     "Maximilien Chopin",
//     "Alfonso Villapol",
//     "Gayla Tincher",
//     "Lelah Pelosi",
//     "Kholmatzhon Daniarov",
//     "Klemens Totleben",
//     "Émeric Figuier",
//     "Joseph Garreau",
//     "Moriya Masanobu",
//     "Fernand Aveline",
//     "Germain Beaumont",
//     "Finn Junkermann",
//     "Benoît Cortot",
//     "Kawano Tanyu",
//     "Gérald Noir",
//     "Lisabeth Brennen",
//     "Jaqueline Phipps",
//     "Roderick Roth",
//     "Adella Tarry",
//     "Rudolf Kirsch",
//     "Fritz Filippi",
//     "Gérald Courbet",
//     "Dastan Nurbolatev",
//     "Oscar Álvarez",
//     "Devon Huntoon",
//     "Marlen Akhmetov",
//     "Cassey Odle",
//     "Patty Balser",
//     "Néo Lortie",
//     "Dieter Krist",
//     "Speranzio Bartolone",
//     "Iside Casaletto",
//     "Durante Sciara",
//     "Ildefonso Sollami",
//     "Xose Mendez",
//     "Vladimiro De Angelo",
//     "Gianmaria De Sario",
//     "Anacleto Adornetto",
//     "Sigmund Bruckmann",
//     "Valtena Amodei",
//     "Liberatore Accordino",
//     "Alfredo Lamanna",
//     "Kemberly Roza",
//     "Lluciano Marcos",
//     "Fukumoto Shusake",
//     "Branda Goshorn",
//     "Isadora Heer",
//     "Micael Montes",
//     "Derrick Sclafani",
//     "Thibault Silvestre",
//     "Wendelin Jonas",
//     "Coleen Dragon",
//     "Ted Basye",
//     "Emmanuel Gillie",
//     "Lorean Soni",
//     "Reiko Jeanlouis",
//     "Olevia Lauder",
//     "Savannah Brotherton",
//     "Franchesca Schwebach",
//     "Chae Jiang",
//     "Jaimee Harter",
//     "Windy Milnes",
//     "Takako Ream",
//     "Zoraida Swick",
//     "Mammie Aguiniga",
//     "Wendi Raver",
//     "Clarita Pursell",
//     "Diedra Spath",
//     "Tandy Hoyte",
//     "Lanie Edwin",
//     "Marchelle Dowden",
//     "Susann Masson",
//     "Jannette Wilmes",
//     "Lakisha Mullenix",
//     "Shanda Gatling",
//     "Kathi Okamura",
//     "Ellie Julius",
//     "Demarcus Mcmullen",
//     "Major Woodrum",
//     "Alpha Um",
//     "Prudence Rodden",
//     "Shante Dezern",
//     "Emma Carra",
//     "Starr Lheureux",
//     "Verline Cordon",
//     "Carla Poole",
//     "Alisa Watts",
//     "Maariya Kramer",
//     "Aamir Boyd",
//     "Antonio Levine",
//     "Della Drew",
//     "Miriam Perry",
//     "Sarina Santos",
//     "Armaan Ellison",
//     "Graham Rankin",
//     "Aasiyah Haney",
//     "Debbie Tanner",
//     "Yuvraj Wolf",
//     "Eleri Barnes",
//     "Ira Forster",
//     "Gage Edmonds",
//     "Nour Hartman",
//     "Niam Mullins",
//     "Mahi Reid",
//     "Winston Hyde",
//     "Rosalie Robertson",
//     "Samirah Hood",
//     "Bonnie Montes",
//     "Aliya Fernandez",
//     "Renesmae Knapp",
//     "Enrique Lutz",
//     "Korey Wu",
//     "Andrea Xiong",
//     "Daanyal Shepard",
//     "Efan Wharton"
// ];

// var dates = [
//     "2018-10-26",
//     "2019-1-1",
//     "2018-11-15",
//     "2018-11-6",
//     "2019-01-7",

//     "2019-1-13",
//     "2019-2-12",
//     "2019-1-17",
//     "2018-2-19",
//     "2019-3-16",

//     "2019-1-14",
//     "2018-2-25",
//     "2019-3-5",
//     "2018-1-18",
//     "2019-2-22",

//     "2018-1-11",
//     "2018-12-12",
//     "2018-11-8",
//     "2019-1-2",
//     "2019-01-13",
//     "2019-05-19",
//     "2019-04-29",
//     "2019-06-12",
//     "2019-07-01",
//     "2019-06-23",
//     "2019-05-24",
//     "2018-10-29",
//     "2019-3-3",
//     "2019-1-7",
//     "2018-10-27",
//     "2019-2-17",
//     "2019-05-24",
//     "2019-06-06",
//     "2019-06-19",
//     "2019-06-22",
//     "2019-06-13",
//     "2019-05-13",
//     "2019-07-01",
//     "2019-04-25",
//     "2019-04-04",
//     "2019-05-05",
//     "2019-05-19",
//     "2019-06-01",
//     "2019-05-27",
//     "2019-03-27",
//     "2019-04-01",
//     "2019-05-30",
//     "2019-06-04"
// ];

// function handleServerResponse(responseCode) {
//     // var responseWoocomerce = response.status;

//     if (responseCode === 200) {
//         displayToast("Reviews imported successfully", "black");
//         jQuery(".loader2").css({
//             display: "none"
//         });
//     } else {
//         displayToast("Error while inserting the product", "red");
//         jQuery(".loader2").css({
//             display: "none"
//         });
//     }
// }