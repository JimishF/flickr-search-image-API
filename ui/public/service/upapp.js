
    function getInfo(){
    
      var image = document.getElementById('image_preview');
            image.crossOrigin = "Anonymous";
            var colorThief = new ColorThief();
            var dominantArray=colorThief.getColor(image);
            var dominantHex=rgbToHex(dominantArray[0],dominantArray[1],dominantArray[2]);
            var n_match  = ntc.name("#"+dominantHex);
            var dominantColor=n_match[1];
            var paletteHex=[];
            
       
            var pelleteArray=colorThief.getPalette(image);  
            var paletteColorArray=[];    
            
            for(var i=0;i<9;i++){
                paletteHex[i] = rgbToHex(pelleteArray[i][0],pelleteArray[i][1],pelleteArray[i][2]);
                var nmatch  = ntc.name("#"+paletteHex[i]);
                paletteColorArray.push(nmatch[1]);
            }
        
          console.log(dominantColor);
          STATE.colorData = {
            "dominantColor" : dominantColor,
            "dominantHex" : dominantHex,
            "paletteColorArray":paletteColorArray,
            "paletteHex" : paletteHex
          }
          console.log(JSON.stringify(paletteColorArray));
          console.log(JSON.stringify(paletteHex));
      //post the data

    }
    function rgbToHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
    function toHex(n) {
    n = parseInt(n,10);
    if (isNaN(n)) return "00";
    n = Math.max(0,Math.min(n,255));
    return "0123456789ABCDEF".charAt((n-n%16)/16)
          + "0123456789ABCDEF".charAt(n%16);
    }
        STATE = {
            validRedirect : true,
            photox : false,
        };

$(document).ready(function(){

        $(".progress").hide(100);

        $(window).bind('beforeunload', function(){
            if( !STATE.validRedirect )
            {
                return 'Data will be destroyed. Are you sure you want to leave?';
            }
        });

            $("#image_selector").change(function(ex) {
                
                $("#btnselfile").attr("disabled","");
                $("#btnselfile").text("Uploading..");
                $(".progress").show(100);
                
                var reader = new FileReader();

                reader.onload = function(e) {
                    var data = e.target.result.substr(e.target.result.indexOf(",") + 1, e.target.result.length);
                    $("#image_preview").attr("src", e.target.result);

                    getInfo();
                    // return;
                    // console.log(data);
                    $.ajax({
                        url: 'https://api.imgur.com/3/image',
                        headers: {
                            'Authorization': 'Client-ID bd64ae40cbb0f86'
                        },
                        type: 'POST',
                        data: {
                            'image': data,
                            'type': 'base64'
                        },
                       
                        xhr: function() {
                            STATE.photox = false;
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function(evt) {
                              if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                /* update status bar */
                                $('.determinate').css("width",percentComplete+"%");

                                console.log(percentComplete);
                                if (percentComplete === 100) 
                                {
                                    console.log("Rangoli submitted, done..");
                                    $("#btnselfile").text("Uploaded");
                                    $(".progress").hide(100);
                                }
                              }
                            }, false);

                            return xhr;
                          },
                        success: function(response) {
                            STATE.res = 
                            {
                                title   : $("#title").text(),
                                url     : response.data.link,
                                id :   response.data.id
                            }

                            var sq_url  = response.data.link;

                            sq_url = sq_url.replace(".png","b.png");
                            sq_url = sq_url.replace(".jpg","b.jpg");
                            sq_url = sq_url.replace(".jpeg","b.jpeg");
                            sq_url = sq_url.replace(".bmp","b.bmp");
                            sq_url = sq_url.replace(".tiff","b.tiff");
                            
                            STATE.res.sq_url = sq_url;
                            STATE.photox = true;
                            

                            // $("#image_preview_2").attr("src", response.data.link);

                        }, error: function() {
                            alert("Error while uploading...");
                        }
                    });
                };
                reader.readAsDataURL(this.files[0]);
            });
                    jQuery.validator.setDefaults({
                          // debug: true,
                          success: "valid"
                        });
                        $("#mainForm").validate({
                          rules: {
                            field: {
                              required: true,
                              step: 10
                            }
                          },
                           errorPlacement: function(error, element) {
                            $(element).closest('label').remove();
                           }
                      });

                $("#mainForm").submit(function(){
                    console.log(STATE.photox);
                    // return false;
                    if( $(this).valid() ){
                        if(STATE.photox != true){
                            alert("Click on \"SELECT RANGOLI PHOTO\" button.");
                            $("#image_selector")[0].focus();
                            return false;
                        }
                        $("#sbmtbtn").attr("disabled","");
                        $("#sbmtbtn").text("Submitting Your Rangoli..");
                        var f_data = $("#mainForm").serialize();
                        $.post("./service/newimage.php",
                        { 
                            state_data : STATE,
                            f_data : f_data
                        }).done(function(d){
                        $("#sbmtbtn").text("Submittied");

                            alert("Rangoli Has been Submittied. Our Best Wishes are with you for win !!");
                            window.location.href = "/";
                        });
                    }
                     return false;
                });

                $("#image_preview").click(function(e){
                    e.stoppropagation();
                    return;
                    // alert("lol");
                });
                
                $('input#input_text').characterCounter();

            $('.datepicker').pickadate({
                    selectMonths: true, 
                    selectYears: 80,
                    max:new Date()
                  });

                  $('input.prof').autocomplete({
                    data: {
                        "Student":null,
                        "Housewife":null,
                        "Service":null
                    }
                });

                  $('input.study').autocomplete({
                    data: {
                        "School": null,
                        "College ":null,
                        "Graduate":null,
                        "Post Graduate":null 
                    }
                });

})       