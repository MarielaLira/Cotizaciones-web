$(document).ready(function() {    

/////////////////////////////////////////////////////////////////////////////// others
function getRandom(min,max){
  max = max-min;
  return Math.floor((Math.random() * max) + min);
}    



//img tag to svg 
jQuery('img.svg').each(function(){
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');

});





//////////////////////////////////////////////////////////////////////// time support //////////////////////////////////////////////////////
var frame = 0;
var fps = 120;
function timeControl(){
  frame++;
  if(frame > fps){
      frame= 0;
  }
  return 0;
}

function timeKey(key){
  if(frame%key==0){
   return true;
  }
  return false;
}




// //////////////////////////////////////////Init
(function() {
  var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  window.requestAnimationFrame = requestAnimationFrame;
})();

var animationList=[];
function searchAnimations(){
  var animationsFound = document.getElementsByClassName("space");
  for(var i=0; i<animationsFound.length; i++){
     var tempElement = animationsFound[i];
     var classList = tempElement.className.split(/\s+/);

     for(j=0; j<classList.length; j++){
       switch(classList[j]){
          case "spaceLevitate":
            checkAnimationList(classList[j]);
          break;
          case "spaceSorter":
            checkAnimationList(classList[j]);
          break;
          case "spaceShake":
            checkAnimationList(classList[j]);
          break;
          case "spaceMasonry":
            checkAnimationList(classList[j]);
            // classList.splice(j,1);
          break;
       }
     }
  }
}
function checkAnimationList(animation){
  for(var ical=0; ical<animationList.length; ical++){
    if(animationList[ical] == animation){
       return 0;
    }
  }
  animationList.push(animation);
  return 0;
}
searchAnimations();



// ///////////////////////////////////animations
function callAnimations(){
  for(ica=0; ica<animationList.length; ica++){
    switch(animationList[ica]){
       case "spaceLevitate":
         spaceLevitate();
       break;
       case "spaceSorter":
         spaceSorter();
       break;
       case "spaceShake":
         spaceShake();
       break;
       case "spaceMasonry":
         spaceMasonry();
       break;
    }
  }
  return 0;
}

// ////////////////////Levitate
var levitateVal=0;
var levitateUp=true;
var levitateSwitcher =true;
var levitateMaxPos= 5;
var levitateTime = 2;
var levitateIncrease = 0.2;
var getLevitateElements = false;
var levitateElements = 0;
function spaceLevitate(){
  if(getLevitateElements == false){
    levitateElements = document.getElementsByClassName("spaceLevitate");
    getLevitateElements=true;
  }
  if(levitateUp == true){
    if(levitateVal < levitateMaxPos/2){
      levitateVal +=levitateIncrease;
    }
    else if(levitateVal < levitateMaxPos){
      levitateVal +=levitateIncrease/1.5;
    }
    if(levitateVal >= levitateMaxPos){
      levitateUp = false;
    }
  }
  else if(levitateUp == false){
    if(levitateVal > -levitateMaxPos/2){
      levitateVal -=levitateIncrease;
    }
    else if(levitateVal > -levitateMaxPos){
      levitateVal -=levitateIncrease/1.5;
    }
    if(levitateVal <= -levitateMaxPos){
      levitateUp = true;
    }
  }
  var movePx = levitateVal + "px";
  for(var i=0; i<levitateElements.length; i++){
      $(levitateElements[i]).css("top",movePx);
  }
  
  
  return 0;
}



//////////////////////////////////////////Sorter
var getSortElements = false;
var allSortElements = 0;
var actualSortElements = 0;
var timeSortShow = 0;
var sortButtons = 0;
function spaceSorter(){
  if(getSortElements == false){
    allSortElements = document.getElementsByClassName("spaceSortElement");
    getSortElements=true;
    for(var i=0; i<allSortElements.length; i++){
      $(allSortElements[i]).removeClass('spaceSortShow1');
      $(allSortElements[i]).removeClass('spaceSortShow2');
    }
    spaceSort(2);
  }
  if(sortOrderIter>=-5 && sortOrderIter <0){
    if(timeKey(2)==true){  
      sortOrderIter ++;
    }
  }
  else if(sortOrderIter>=0){
    if(timeKey(8)==true){  
      $(actualSortElements[sortOrder[sortOrderIter]]).addClass('spaceSortShow2');
      sortOrderIter ++;
      if(sortOrderIter > sortOrder.length ){
        sortOrderIter = -6;
      }
    }
  }
  return 0;
}
var sortOrderIter = -6;
spaceShowSort = function(sortNum){
  if(sortOrderIter != -6){
   return 0;
  }
  for(var i=0; i<allSortElements.length; i++){
    $(allSortElements[i]).removeClass('spaceSortShow1');
    $(allSortElements[i]).removeClass('spaceSortShow2');
  }
  if(sortNum == 0){
    var temp = "spaceSortElement";
  }
  else{
    var temp = "spaceSortNum"+sortNum;
  }
  actualSortElements = document.getElementsByClassName(temp);
  sortSequence(false);
  sortOrderIter = -5;
  for(var i=0; i<actualSortElements.length; i++){
    $(actualSortElements[i]).addClass('spaceSortShow1');
    
  }
  return 0;
}
var sortOrder = [];
function sortSequence(rand){
  sortOrder = [];
  for(var i=0; i<actualSortElements.length; i++){
    sortOrder.push(i);
  }
  if(rand == true){
   sortOrder.sort(function(a, b){return 0.7 - Math.random()});
  }
  return 0;
}





///////////////shake
var shakeElements = 0;
var getShakeElements = false;
var shakeTimer = 0;
var shakeVal = 3;
var shaking=false;
var shakesCount=0;
var shakeTimeControl = true;
function spaceShake(){
  if(getShakeElements == false){
    shakeElements = document.getElementsByClassName("spaceShake");
    getShakeElements=true;
  }
  if(shakeTimer <= 0){
    if(shaking == false){
      shakeTimer = getRandom(5,10);
      return 0;
    }
    else{
      shakeAnimate();
    }
  }
  else if(shakeTimer > 0 && timeKey(60)==true && shakeTimeControl == true){
    shakeTimer --;
    shaking = true;
    shakesCount = 4;
    shakeTimeControl = false;
  }
  if(timeKey(60)==false && shakeTimeControl == false){
    shakeTimeControl = true;
  }
}
function shakeAnimate(){
  if(shakeVal >= -3 && shakesCount > 0){
      shakeVal --;
  }
  else if(shakeVal < -3){
    shakesCount --;
    shakeVal = 3;
  }
  if(shakesCount <= 0){
    shaking = false;
    shakeVal = 0;
    for(var i=0; i<shakeElements.length; i++){
      $(shakeElements[i]).css("transform",rotation);
    }
  }
  var rotation = "rotate("+shakeVal+"deg)"
  for(var i=0; i<shakeElements.length; i++){
    $(shakeElements[i]).css("transform",rotation);
  }
}







// ////////////////////////////////////////space masonry
var tileElements = 0;
var masonryMain = 0;
var masonryInit = false;
var masonryWidth = 0;
var columnLast = 0;
function spaceMasonry(){
  if(masonryInit == false){
    tileElements = document.getElementsByClassName("spaceTile");
    masonryMain = document.getElementsByClassName("spaceMasonry");
    masonryMain = masonryMain[0];
    masonryInit = true;
    
    var switcher = false;
    var column1H = 0;
    var column2H = 0;
    for(var i = 0; i<tileElements.length; i++){
      if(switcher == false){
        tileElements[i].style.left = "0";
        tileElements[i].style.top = column1H+"px";
        column1H += tileElements[i].offsetHeight;
        // console.log(column1H);
        switcher = true;
      }
      else{
        tileElements[i].style.right = "0";
        tileElements[i].style.top = column2H+"px";
        column2H += tileElements[i].offsetHeight;
        switcher = false
      }
    }

    if(column2H > column1H){
      columnLast = column2H;
    }
    else{
      columnLast = column2H;
    }
    masonryMain.style.height = columnLast+"px";

    
  }
  window.addEventListener("resize", 
    function updateMasonry(){
    masonryInit = false;
  });
}






////////////////////////////////////main loop
function spaceMain(){
  timeControl();

  callAnimations();

  requestAnimationFrame(spaceMain);
}
spaceMain();

});

var spaceShowSort;
function spaceSort(num){
  spaceShowSort(num);
}





