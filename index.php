<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
      
        <style>
        #outer {
            width:100%;
            padding:3%;
        }

        #site_instructions{
            position:relative;
            width: 80%;
            margin-left:10%;
        }
        #car_info {
            position:relative;
            width: 90%;
            margin-left:10%;
            float:left;
        }
       
        #body{
            position:relative;
            height:100%;
        }
        #jumbo{
            position:relative;
            margin-right:5%;
            margin-left:2px;
            border: 1px solid black;
            width:55%;
            float:right;
            height:auto;
            padding:2em 0;
        }

        #sideBar{
            position:relative;
            margin-left:5%;

            border: 1px solid lightBlue;
            background-color:lightBlue;

            width:30%;
            float:left;
            height:auto;
            padding:2em 0;
        }


        #searchInfo{
            position:relative;
            width:90%;
            margin-left:10%;
            float:left;
            height:20%;
            padding:2em 0;
        }

        #search_results {
            height:20em;
            width:100%;
            overflow-y:scroll;
            overflow-x:scroll;
        }

        #showCar{
            transform:translate(-10%,0);
        }
        .hdinfo {
          position:relative;
          background-image:linear-gradient(white,black);
          font-size:1.0em;
          height:auto;
          text-align:center;
          padding:0.5em;
            
        }
        .gotosite{
            display: block;
            width: auto;
            height: auto;
            background: #4E9CAF;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            line-height: 25px;
        }
       
        #car_info {
            position:relative;   
            position:relative;
            background-image:linear-gradient(white,lightgrey); 
            height:25%;
            width:100%;
        }

        #results {
            display:none;
        }
        
        #info_carousel {
           
        }

        #search_string {
            background-color:lightGrey;
            border-color:white;
            border-style:solid;
            border-width:1px;
            height:2em;
            font-size:1em;
            padding:3px;
            color:black;
        }

        #previous_searches {
            color:blue;
            background-color:lightblue;
        }

        #iconDisplay > .carousel-inner {
            position:relative;
            background-color:white;
            width:60%;
            height:5em;
            padding:1em;
        }

        #site_selected > h4 {
            background-image:linear-gradient(white,black);
            color:white;
            font-size:0.4;
            padding:2px;
        }

        #siteInfo{
            display:none;
            position:relative;
            z-index:20;
            width:90%;
            margin-left:5%;
            height:30%;
        }

       
        
        </style>
      
        <script type="text/javascript">
            var customResults = '';
            var resultsObj = {};
            var resultsObjArr = [];
            var years = [];
            var searchString = '';
            var cargurus_url =  "https://www.cargurus.com";
            var carmax_url = "https://www.carmax.com";
            var us_news_world_report_url = "https://cars.usnews.com";
            var carvana_url = "https://carvana.com";
            var carsite_url = "";
            var carousel_inner = "";
            var carousel_inner2 = "";

            var imgArr = {"carimages":[]};
            const doGoogleSearch = function(url) {

                window.__gcse = {};
                const myInitCallback = function() {
           
                    // Document is ready when Search Element is initialized.
                    // Render an element with both search box and search results in div with id 'test'.
                    google.search.cse.element.render(
                        {
                            div: "search",
                            tag: 'searchbox',
                            gname: 'search',
                            attributes:  {
                                as_sitesearch : url,
                                linkTarget : "_self"
                            }
                        },
                        {
                            div: "results",
                            tag: 'searchresults',
                            gname: 'search', 
                           
                        } 

                    );
          
           };

            const getResults = function(name, q, promos, results, resultsDiv){
                customResults = $('#custom_results');
               
                carousel_inner = $('<div class="carousel-inner d-flex justify-content-center">');
                
                let results_accordian = $('<div class="accordion" id="accordionExample">');

                const makePromoElt = (promo) => {
                    const anchor = document.createElement('a');
                    anchor.href = promo['url'];
                    anchor.target = '_blank';
                    anchor.classList.add('gs-title');
                    const span = document.createElement('span');
                    span.innerHTML = 'Promo: ' + promo['title'];
                    anchor.appendChild(span);
                    return anchor;           
                };
                
                const makeResultsParts = (result) => {
                    const anchor = document.createElement('a');
                    anchor.href = result['url'];
                    anchor.target = '_blank';
                    anchor.classList.add('gs_title');
                    anchor.appendChild(document.createTextNode(result['visibleUrl']));
                    const ahref = result['visibleUrl'];
                    resultsObj.anchor = anchor;
                    resultsObj.image = result['thumbnailImage'];
                    resultsObj.content = result['content'];
                    resultsObj.title = result['title'];                   
                    const span = document.createElement('span');                    
                    resultsObj.span = span;
                    resultsObjArr.push(resultsObj); 
                    span.innerHTML = ' ' + result['title'];   
                    const content = result['contentNoFormatting'];
                    const title = result['titleNoFormatting'];
                    let carousel_item = '';
                    if(carousel_inner.children().length == 0)
                        carousel_item = $('<div class="carousel-item active">');
                    else
                        carousel_item = $('<div class="carousel-item">');

                    let img = $('<img class="d-block">')
                    if( typeof(result['thumbnailImage']) !== 'undefined'){
                        if( typeof(result['thumbnailImage'].url !== 'undefined' && !imgArr.carimages.includes(result['thumbnailImage'].url))){
                            img.attr("src",result['thumbnailImage'].url);
                            img.attr("height",parseFloat(result['thumbnailImage'].height)*0.75);
                            img.attr("width",parseFloat(result['thumbnailImage'].width)*0.75);
                            img.attr("alt",result['contentNoFormatting']);
                            
                            carousel_item.append(img);
                            carousel_inner.append(carousel_item);      
                                 
                            imgArr.carimages.push({"link":result['thumbnailImage'].url,"search":searchString,"carsite":carsite_url});
                           
                        }  
                    }       
                   
                    return [anchor, span, content, title,imgArr];                 
                };

             


                const table = document.createElement('table');
                if (promos) {
                    for (const promo of promos) {
                        const row = table.insertRow(-1);
                        const cell = row.insertCell(-1);
                        cell.appendChild(makePromoElt(promo));
                    }
                    resultsDiv.appendChild(table);
                    resultsDiv.appendChild(document.createElement('br'));
                }
                
                if (results) {
                    //resultsDiv.innerHTML = '';
                    customResults.innerHTML = '';
                    const table = document.createElement('table');
                    let suffix = ["Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen"];
                    let count = 0;
                    let imgArr2 = [];
                    for (const result of results) {
                        const [ anchor, span, content, title, imgArr ] = makeResultsParts(result);
                          imgArr2 = imgArr;
                          let accordian_item = $('<div class="accordion-item">');
                          let accordian_header = '';
                          let accordian_body = '';

                          if(results_accordian.children().length == 0){
                            accordian_header = $(`<h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                ${title}
                                            </button></h2>`);
                            accordian_body = $(`<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <p>${content}</p>
                                                        <a class="gotosite" href=${anchor} target="_blank">Go To Site</a>
                                                    </div>
                                                </div>`);

                       

                          }
                          else{
                            accordian_header = $(`<h2 class="accordion-header" id="heading${suffix[count]}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${suffix[count]}" aria-expanded="false" aria-controls="collapse${suffix[count]}">
                                                    ${title}
                                                </button>
                                                </h2>`);

                            accordian_body = $(`<div id="collapse${suffix[count]}" class="accordion-collapse collapse" aria-labelledby="heading${suffix[count]}" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <p>${content}</p>                                                            
                                                            <a class="gotosite" href=${anchor} target="_blank">Go To Site</a>
                                                        </div>
                                                    </div>`);

                          }
                          accordian_item.append(accordian_header);
                          accordian_item.append(accordian_body);
                          results_accordian.append(accordian_item);
                          count++;
                    }
                    $('#showCar').append(carousel_inner);
                    $('#iconDisplay').hide();
                    resultsDiv.appendChild(table);
                    customResults.append(results_accordian);
                    storeImageLinks(imgArr2);
                    //customResults.appendChild(table);     
                    carousel_inner = ''; 
                    results_accordian = '';              
                }
                return;
            };

            const clearResults = function(){
                console.log("clearing");
                $("#showCar").html('');
                //$('#custom_results').html('');
                $('#results').html('');
                return true;
            };


            const myResultsReadyCallback = function(name, q, promos, results, resultsDiv){             
                
                    console.log("searching...");
                    clearResults();
                    getResults(name, q, promos, results, resultsDiv);
                return true;
            };

           
                
            const storeImageLinks  = (imgArr) => { 
                fetch('./data.json')
                    .then((response) => response.json())
                    .then((json) => {
                        let imgArr2 = json;
                        console.log(json);
                        let no_carimages = imgArr2.carimages.length;
                        console.log(no_carimages + ":" + imgArr.carimages.length);
                        if(no_carimages > 200)
                            imgArr2 = {"carimages":[]};
   
                        if(imgArr.carimages.length > 0){
                            for(image of imgArr2.carimages){
                                let test = imgArr.carimages.filter(function(img){
                                    return img.link == image.link;
                                });
                                console.log(test);
                                if( test.length == 0)
                                    imgArr.carimages.push(image);
                            }
                        }
                        else {
                            imgArr2 = {"carimages":[]};
                            imgArr.carimages.push(image);
                        }
                        console.log("new length:",imgArr.carimages.length);
                        var myText = JSON.stringify(imgArr);
                        console.log('Textarea: '+myText);
                        var url ="save.php";
                        $.post(url, {"myText": myText}, function(data){

                        console.log('response from the callback function: '+ data); 
                        }).fail(function(jqXHR){
                            alert(jqXHR.status +' '+jqXHR.statusText+ ' $.post failed!');
                        });    


                    });
                };
    



            // Insert it before the Search Element code snippet so the global properties like parsetags and callback
            // are available when cse.js runs.
            
           
            window.__gcse = {
                parsetags: 'explicit',
                initializationCallback: myInitCallback,
                searchCallbacks: {
                    web: {
                        ready: myResultsReadyCallback,
                    }
                }
            };

        };

        const loadMenus = function(search=null)
            {
                searchString = '';           
                let count = 0;
                let prior3 = "";
                for(let i = 1950;i <= new Date().getFullYear();i++){
                    years[count] = i;
                    count++;
                }
                

                fetch('cars.json')
                    .then((response) => response.json())
                    .then((json) => {
                        
                        console.log(json);
                        const cars = json.cars;
                        if(search)
                            searchString = search;
                        else
                            searchString = 'Search For: ';

                        $('#carinfo_dropdown > ul').html('');
                        const car_dropdown_items = `
                            <li><button class="dropdown-item active" type="button" value="https://www.cargurus.com">Car Gurus</button></li>   
                            <li><button class="dropdown-item" type="button" value="https://www.carmax.com">Car Max</button></li>
                            <li><button class="dropdown-item" type="button" value="https://cars.usnews.com">US News and Reports</button></li>   
                            <li><button class="dropdown-item" type="button" value="https://carvana.com">CARVANA</button></li>   
                            <li><button class="dropdown-item" type="button" value="https://truecar.com">TrueCar, Inc.</button></li>  
                            <li><button class="dropdown-item" type="button" value="https://autotrader.com">Autotrader</button></li>   
                        `;
                        $('#carinfo_dropdown > ul').append(car_dropdown_items);
                        $('#carinfo_dropdown > ul > li')
                        .on("click",function(e){
                            let droptext = $(e.target).text();
                            $('#site_selected').fadeIn().find('h4').text("Site Selected: " + droptext);

                            $('#iconDisplay').hide();                            
                            $("#info").text(''); 
                            $("#dropdownMenu4").add('.dropdown-menu').removeClass('show');
                            carsite_url = e.target.value;   
                            let info = '';
                            $('#showCar').css('display','none');
                            $('#siteInfo').css('display','block');
                            $('#iconDisplay').find('.carousel-item').css('display','none');  
                            $('#previous_searches').fadeOut();
                            $('#search_results').fadeOut();
                            setInfoDisplay();
                           
                        });
                        for (const car of cars)
                        {
                            let prior1 = searchString; 
                            let el = $(`<li><button class="dropdown-item make-button" type="button">${car.make.name}</button></li>`)                            
                            .on("click",function(){
                                searchString = 'Search For: ';
                                searchString = prior1 + car.make.name + " ";
                                $("#dropdownMenu4").add('.dropdown-menu').removeClass('show');
                                $("#search_string").text(searchString); 
                                // $('#model_dropdown > ul').html('');
                            
                                for(model of car.make.models){
                                    let prior2 = searchString;
                                    let el2 = $(`<li><button class="dropdown-item" type="button" value="${model}">${model}</button></li>`)                                    
                                    .on("click", function(e){
                                        searchString = prior2 + e.target.value;
                                        prior3 = searchString;                                        
                                        $("#dropdownMenu4").add('.dropdown-menu').removeClass('show');
                                        $("#search_string").text(searchString);
                                        for (year of years.reverse()){
                                            let el = $(`<li><button class="dropdown-item" type="button" value="${year}">${year}</button></li>`)
                                                .on("click", function(e){
                                                    let val = e.target.value;
                                                    let str = val.toString() + " " +  prior3.replace("Search For: ","");
                                                    $("#search_string").text("Search For: " + str);
                                                    searchString = str;
                                                    $("#dropdownMenu2").add('.dropdown-menu').removeClass('show');                                                    
                                                    $("#dropdownMenu4").add('.dropdown-menu').removeClass('show');
                                                });
                                            $('#year_dropdown > ul').append(el);
                                        }

                                        console.log(years);
                                        $('#location > input').attr("disabled",false);
                                       

                                        
                                    });
                                                                
                                    $('#model_dropdown > ul').append(el2);
                                
                                } 
                                
                                //$("#dropdownMenu2").add('.dropdown-menu').addClass('show');
                                $("#custom_results").html('');
                                $('#showCar').html('');

                                
                            })
                            .on('mousedown',function(){
                                $('#model_dropdown > ul').html('');
                            });  
                            $('#make_dropdown > ul').append(el);                  
                        }

                        $('#location > input').on("change",function(e){
                           
                            searchString = "Search For: " + searchString + " " + e.target.value;   
                            $("#search_string").text(searchString); 

                        });

                        
                    });               
                   
            };
            const setInfoDisplay = function(){

                if(carsite_url.includes('gurus')){
                                info = "CarGurus Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:white;color:black;" >
                                                        <img src="images/cargurus.png" class="card-img-top" alt="Car Gurus" style="transform:scale(0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">CarGurus site description</h5>
                                                            <p class="card-text">CarGurus Inc (CarGurus) is a marketplace to buy and sell cars. The company offers new cars and used and certified 
                                                                pre‑owned cars and also helps owners merchandise their vehicles through sell my car. It offers sports utility vehicles, new and used 
                                                                passenger cars, vans, hatchbacks, convertibles, and pickup trucks.
                                                            </p>       
                                                        </div>                                                                                 
                                                    </div>`);

                                //$('#iconDisplay').find('.carousel-item:not(".cargurus")').css('display','none');                
                            }
                            else if(carsite_url.includes("carmax")){
                                info = "CarMax Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:lightGrey;color:black;">
                                                        <img src="images/carmax.png" class="card-img-top" alt="Car Gurus" style="transform:scale(0.6)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">CarMax site description</h5>
                                                            <p class="card-text">CarMax, Inc. is a holding company, which engages in the retail of used vehicles and wholesale vehicle 
                                                                auction operator. It operates through the CarMax Sales Operations and CarMax Auto Finance (CAF) segments. 
                                                                The CarMax Sales Operations segment consists of all aspects of its auto merchandising and service operations.
                                                            </p>     
                                                        </div>
                                                                                  
                                                    </div>`);
                                //$('#iconDisplay').find('.carousel-item:not(".carmax")').css('display','none');                    
                            }
                            else if(carsite_url.includes("usnews")){
                                info = "US News & World Reports Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:lightGrey;color:black;">
                                                        <img src="images/us news & world reports.png" class="card-img-top" alt="Car Gurus" style="transform:scale(0.6)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">US News & World Reports site description</h5>
                                                            <p class="card-text">U.S. News & World Report (USNWR) is an American media company that publishes news, consumer advice, rankings, and analysis.
                                                            It was launched in 1948 as the merger of domestic-focused weekly newspaper U.S. News and international-focused weekly magazine World Report.
                                                            </p>      
                                                        </div>
                                                                                 
                                                    </div>`);
                                //$('#iconDisplay').find('.carousel-item:not(".usnews")').css('display','none');                   
                            }
                            else if(carsite_url.includes("carvana")){
                                info = "Carvana Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:lightGrey;color:black;">
                                                        <img src="images/carvana.png" class="card-img-top" alt="Carvana" style="transform:scale(0.6)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">Carvana site description</h5>
                                                            <p class="card-text">Carvana is an online-only used-car retailer that performs almost all the functions a physical dealer would offer: buying and 
                                                                selling cars, accepting trade-ins, and financing purchases. Naturally, the company's site contains a thorough FAQ page, 
                                                                but here's a primer on how it works.
                                                            </p>      
                                                        </div>
                                                                                 
                                                    </div>`);
                                //$('#iconDisplay').find('.carousel-item:not(".usnews")').css('display','none');                   
                            }
                            else if(carsite_url.includes("truecar")){
                                info = "TrueCar, Inc. Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:lightGrey;color:black;">
                                                        <img src="images/truecar.png" class="card-img-top" alt="TrueCar, Inc." style="transform:scale(0.5)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">TrueCar, Inc. site description</h5>
                                                            <p class="card-text">What is TrueCar? TrueCar is an information and technology platform that enables its users to communicate with TrueCar 
                                                               Certified Dealers for a great car buying experience. Our mission is simple: make the car buying process simple, fair and fun.
                                                            </p>      
                                                        </div>
                                                                                 
                                                    </div>`);
                                //$('#iconDisplay').find('.carousel-item:not(".usnews")').css('display','none');                   
                            }
                            else if(carsite_url.includes("autotrader")){
                                info = "Autotrader Site will be Searched";
                                $('#siteInfo').html(`<div class="card text-center rounded" style="background-color:white;color:black;">
                                                        <img src="images/autotrader.png" class="card-img-top" alt="Autotrader" style="transform:scale(0.6)">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color:blue">Autotrader site description</h5>
                                                            <p class="card-text">Autotrader.com, Inc. is an online marketplace for car buyers and sellers, founded in 1997. It aggregates new, used, 
                                                            and certified second-hand cars from dealers and private sellers. The site also provides users with automotive reviews, shopping advice, 
                                                            and comparison tools for car financing and insurance information.
                                                            </p>      
                                                        </div>
                                                                                 
                                                    </div>`);
                                //$('#iconDisplay').find('.carousel-item:not(".usnews")').css('display','none');                   
                            }
                            else{    
                                info = "Likely the General Internet being Searched";
                            }
                            
                            $("#info").text(info).fadeIn();

            };

            const loadGSC = function(){
                const body = document.querySelector("body");
                const script = document.createElement("script");
                script.setAttribute("src","https://cse.google.com/cse.js?cx=318cd2c843852489f");               
                script.setAttribute("async",true);
                body.appendChild(script);
            };

            const prepareSearch = function(url,search){
                carsite_url = url;
                loadMenus(search);
                loadGSC();
                $('#search').html('');
                $('#search_results').html('<div id="custom_results" class="col" ></div>');
                $('#search_results').attr('top','-40%');
                $('#search_string').text('').css('transform','scale(1)').fadeIn();
                $('#info').text("Select Site and Car For a Lot Of Info").css('transform','scale(1)').css('z-index','1').css('padding','3px').fadeIn();
                $('#search_string').text("Search For: " + search);
                $('#iconDisplay').fadeOut();
                $('#previous_searches').fadeOut();
                setInfoDisplay();
                loadGoogleSearch(search);
            };

            const hintSearch = function(url,search){
                search = search.replace("Search","").replace("For","").replace(":","");
                $('#search_string').text(search).css('color','red').fadeIn();
                $('#info').text("Repeat Search For: " + search).css('color','red').fadeIn();

                $(".do-search").on("mouseover mouseenter", function(){
                    
                    $(this).tooltip();
                    $(this).attr('data-toggle','tooltop').attr('title',"Repeat Search For: " + search).attr('data-placement','left');
                    $(this).focus();

                    $(this).on('mouseleave',function() {
                        $('#search_string').text('').css('transform','scale(1)').fadeIn();
                        $('#info').text("Select Site and Car For a Lot Of Info").css('transform','scale(1)').css('z-index','1').css('padding','3px').fadeIn();
                    });
                });
            };

           

            const loadGoogleSearch = function(search=null) {
                if(search)
                    searchString = search;
                doGoogleSearch(carsite_url);  
                
                $('#info').append('<p id="waiting">Please Wait....</p>');

                setTimeout(function(){
                    google.search.cse.element.getElement('search').clearAllResults();                       
                    $('#gsc-i-id1').attr('data-as_sitesearch',carsite_url);                        
                    google.search.cse.element.getElement('search').prefillQuery(searchString); 
                    google.search.cse.element.getElement('search').execute(searchString); 

                    $('#info').find('#waiting').remove();
                    let pattern = /was Searched.*/g;
                    let res =  $('#info').text().match(pattern);
                    let text;
                    if(!res)
                        text = $('#info').text().replace("will be Searched","was Searched");
                    else
                        text = $('#info').text().replace(res," was Searched");

                    let addon = $("#search_string").text().replace("Search For:","for ");
                    $('#info').text(text);

                    $('#info').append("<p>" + addon + "</p>");
                    $("#search_string").text("");
                    //alert(JSON.stringify(imgArr));
                    $('#showCar').css('display','block');
                    $('#siteInfo').css('display','none');

/*
                    var myText = JSON.stringify(imgArr);
                    console.log('Textarea: '+myText);
                    var url ="save.php";
                    $.post(url, {"myText": myText}, function(data){
                        console.log('response from the callback function: '+ data); 
                    }).fail(function(jqXHR){
                        alert(jqXHR.status +' '+jqXHR.statusText+ ' $.post failed!');
                    });
                    
                    
                    */
                },3000);
            };
        
           
            const getPreviousSearches = (carimages) => {
                console.log(carimages.length);
                if(carimages.length > 0){
                    let count = 0;
                    let nochild = 1;
                    let count2 = 0;
                    $('#search_results').html('');
                    $('#search_results').append('<div class="row text-center w-100 m-1"></div>');
                    for(image of carimages){
                        let carsite = image.carsite;
                        let search = image.search;
                        console.log(search);
                        let el = $(`<div class="col">
                            <img src="${image.link}" class="seach-image img-fluid img-thumbnail" alt="Car Image">
                            <button type="button" class="do-search" onclick="prepareSearch('${carsite}','${search}')" onmouseover="{hintSearch('${carsite}','${search}');}"  
                                    style="position:relative;left:30%;top:-30%;font-size:0.5em;display:none;z-index:30;"class="btn btn-primary">Load Search</button>
                            </div>`);
                        
                        if(count > 7){
                            console.log("appending");
                            $('#search_results').append('<div class="row text-center w-100 m-1"></div>');
                            nochild++;
                            count = 0;
                        }

                        $('#search_results').append(el);
                        count++;     
                        count2++;
                        if(count2 > 100)
                            break;                      

                    }

                    $('.img-fluid').parent().on('mouseover',function(){
                        $(this).find('.do-search').css('display','block');
                        $(this).css('z-index','20').css('transform','scale(1.5)').css('margin-top','5%');

                    });

                    $('.img-fluid').parent().on('mouseleave',function(){
                        $(this).find('.do-search').css('display','none');
                        $(this).css('z-index','1').css('transform','scale(1)').css('margin-top','0');

                    }); 
                }
                else {
                    $('#search_results').html('');
                }
            
            };

            const clearSearches = () => {
                getPreviousSearches([])
                var myText = JSON.stringify({"carimages":[]});
                console.log('Textarea: '+myText);
                var url ="save.php";
                $.post(url, {"myText": myText}, function(data){
                    console.log('response from the callback function: '+ data); 
                    window.location.reload(); 
                }).fail(function(jqXHR){
                    alert(jqXHR.status +' '+jqXHR.statusText+ ' $.post failed!');
                });    


            };



            $(document).ready(function(){
                const statements = [
                    {el: `<div class="container"><p class="hdinfo rounded">Get Car Info from Different Sites!</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Sites like: CarMax, Cargurus, US News and Reports, and others</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Use Dropdowns to Select Car and Year</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Type In Location (State and/or City and/or Zip Code) and PRESS ENTER</p></div>`}, 
                    {el: `<div class="container"><p class="hdinfo rounded">Year and Location are Optional</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Display Fields Show Search Site and Criteria</p></div>`},
                    {el:`<div class="container"><p class="hdinfo rounded">Press 'Do Search' button and Wait a Just a Moment</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Accordian Display Appears with Car Info Set tailored to your search criteria.</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Press Accordian Arrows to Open/Close Description of Found Site!</p></div>`},
                    {el: `<div class="container"><p class="hdinfo rounded">Each Accordian Tab has 'Go To Site' which will open in another tab.</p></div>`},

                ];

                let carousel_item = '';           
                $('#previous_searches').fadeIn();
                
                carousel_inner2 = $('<div id="for_info" class="carousel-inner d-flex">');
                $("#info_carousel").append(carousel_inner2);
                for (const statement of statements){
                    if(carousel_inner2.children().length == 0)
                        carousel_item = $('<div class="carousel-item align-content-center active">');
                    else
                        carousel_item = $('<div class="carousel-item align-content-center">');

                    carousel_item.append(statement.el)
                    carousel_inner2.append(carousel_item)
                }
                $("#info_carousel").append(carousel_inner2);


                
               
                // Fetch Data for and Do Logic for Previous Search Display
                fetch('./data.json')
                    .then((response) => response.json())
                    .then((json) => {
                      getPreviousSearches(json.carimages);
                    });

           
                    
             
                searchString = '';   
                loadMenus();


                $('#dosearch').on("click",function(){
                        loadGSC();
                        $('#search').fadeOut();
                        $('#search_results').html('<div id="custom_results" class="col" ></div>');
                        $('#search_results').attr('top','-40%');                       
                        if(!carsite_url){
                            carsite_url = cargurus_url;
                            alert("Please Select a Car Site!");
                        }
                        else{
                            loadGoogleSearch();
                            $("#dropdownMenu2").add('.dropdown-menu').removeClass('show');
                            $('#year').val('');
                            $('#search_results').fadeIn();
                        }
                      
                });   

            /*    
            $('#search_results').on("DOMSubtreeModified",function(){
                    var myText = JSON.stringify(imgArr);
                    console.log('Textarea: '+myText);
                    var url ="save.php";
                    $.post(url, {"myText": myText}, function(data){

                    console.log('response from the callback function: '+ data); 
                    }).fail(function(jqXHR){
                        alert(jqXHR.status +' '+jqXHR.statusText+ ' $.post failed!');
                    });    
                });
            */
            $('#model_dropdown > ul').on("mouseover",function(){
               
                  let test =  $(this).html().replace("\\n","").replace(/\s+/g, '').toString().length;
                  if(test === 0){
                    alert("Please select Car Make First!");
                  }

            });


            $('#year_dropdown > ul').on("mouseover",function(){
               
               let test =  $(this).html().replace("\\n","").replace(/\s+/g, '').toString().length;
               if(test === 0){
                 alert("Please select Car Model First!");
               }

         });



            });
        </script>
            
       
    </head>
    <body>    
        <div id="outer">
            <div id="jumbo" class="p-2 bg-primary text-white rounded container">
                <div id="carinfo_header" class="row">
                    <div id="get_car_info" class="row text-center justify-content-center w-100 m-1">
                        <h1>Get Car Info</h1>
                    </div>
                    <div id="site_instructions" class="row text-center justify-content-center">
                        <div id="info_carousel" class="carousel slide" data-bs-ride="carousel"></div>
                    </div>   
                </div>

                <div class="row">
                    <div id="showCar" class="carousel slide align-items-center justify-content-center mt-2" data-bs-ride="carousel"></div>
                </div>    
                <div id="siteInfo" class="row mb-2"></div> 
                <div id="iconDisplay" class="carousel slide align-items-center justify-content-center row" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active align-items-center cargurus">
                            <img src="images/cargurus.png" style="position:relative;margin: 0 0 25% 25%" class="d-block" width="200" height="50" alt="CarGurus">
                        </div>
                        <div class="carousel-item site-carmax">
                            <img src="images/carmax.png" style="position:relative;margin: 0 0 25% 25%"   class="d-block" width="200" height="50" alt="CarMax">
                        </div>
                        <div class="carousel-item site-usnews">
                            <img src="images/us news & world reports.png" style="position:relative;margin: 0 0 25% 25%"  class="d-block" width="200" height="50" alt="US News & Reports">
                        </div>
                        <div class="carousel-item site-carvana">
                            <img src="images/carvana.png" style="position:relative;margin: 0 0 25% 25%"  class="d-block" width="200" height="50" alt="Carvana">
                        </div>
                        <div class="carousel-item site-truecar">
                            <img src="images/truecar.png" style="position:relative;margin: 0 0 25% 25%"  class="d-block" width="200" height="50" alt="TrueCar">
                        </div> 
                        <div class="carousel-item site-autotrader">
                            <img src="images/autotrader.png" style="position:relative;margin-left:38%"  class="d-block" width="200" height="50" alt="Autotrader">
                        </div> 
                    </div>
                </div>  

                <div class="row text-center justify-content-center">   
                    <h2 id="site_selected" style="display:none;"></h2>
                </div>   
            </div>
            
            <div id="sideBar" class="container p-2">      
                <div id="carinfo_dropdown" class="dropdown mb-1">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-bs-toggle="dropdown" aria-expanded="false">
                        Choose Car Site
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                    </ul>
                </div>  
                <div id="make_dropdown" class="dropdown mb-1">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                        Car Make
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="height:350px; overflow-y: scroll;">                  
                    </ul>
                </div>  
                <div id="model_dropdown" class="dropdown mb-1">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        Car Model
                    </button>
                    <ul class="dropdown-menu" style="height:350px; overflow-y: scroll;" aria-labelledby="dropdownMenu2">                  
                    </ul>
                </div>    
            
                <div id="year_dropdown" class="dropdown mb-1">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu3" data-bs-toggle="dropdown" aria-expanded="false">
                        Car Year
                    </button>
                    <ul class="dropdown-menu" style="height:350px; overflow-y: scroll;" aria-labelledby="dropdownMenu3">                  
                    </ul>
                </div>    
                
                <div id="location" class="input-group mb-1">
                    <input type="text" class="form-control" placeholder="Input Location" aria-label="Car Location" aria-describedby="basic-addon2"  disabled>
                </div>
                <div class="container">
                    <h2 id="search_string" class="p-2 pb-2"></h2>
                </div>
                <div class="container">
                    <button id="dosearch" type="button" class="btn btn-light">Do Search</button>    
                    <button id="reset" onclick="window.location.reload()" type="button" class="btn btn-light">Reset/Previous Searches</button> 
                    <button type="button" onclick="clearSearches()" class="btn btn-light">Clear All Searches</button>    
                </div>
                
            </div>    
            
            <div id="car_info" class="container p-2 text-center mt-3">            
                <div class="row text-center mt-1">
                    <h5 id="info" style="color:blue">Select Site and Car For a Lot Of Info</h5>
                </div>
                <div class="row justify-content-center">
                    <div id="search" class="col gcse-searchbox" data-as_sitesearch="" data-gname="search"></div>
                </div>   
                <div class="row" id="results_wrapper">
                    <div id="results" class="gcse-searchresults" data-gname="search"></div>
                </div>   
            </div>
            <div class="container" id="searchInfo">
                <div id="previous_searches" class="col text-center p-1 mt-1">
                        <h3>Images Represent Previous Searches<br>Hover and Click to Repeat Search</h3>
                </div>  
                <div id="search_results" class="row m-2 justify-content-center">        
                        
                    <div id="custom_results" class="col" ></div>         
                </div>        
            </div>
        </div>
        
        
        
        <!--div class="gcse-searchbox"></div>
        <div class="gcse-searchresults"></div-->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- Load React. -->
        <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
        <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>  
        <!-- Load our React component. -->

    </body>
</html>