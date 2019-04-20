function showHideToggler(e,id) {
    e.preventDefault();
    var x = document.getElementById(id);
    if (x.style.display === 'none') {
      x.style.display = '';
    } else {
      x.style.display = 'none';
    }
}
function openTab(e,tab){
  var tabs = document.getElementsByClassName('tab');
  for(var i=0;i<tabs.length;i++){
      if(tabs[i].id == tab){
          tabs[i].style.display = "block";
      }else{
          tabs[i].style.display = "none";
      }
  }
}
$("#searchbox").change(function(){
    var $tasks = $('#tasks');
    var searchval = $('#searchbox').val();
    $.ajax({
        type:'GET',
        url:'/api/tasks',
        data: { 
            "s": searchval
        },
        cache: false,
        success:function(tasks){     
            $tasks.empty();
            $tasks.append('<div class="alert alert-success col-"> <span class="fa fa-search"> <strong>'+tasks.meta.total+' result found for Search = '+searchval+'</span></strong></div>');
            $.each(tasks.data,function(i,task){
                $tasks.append('<a href="tasks/'+task.id+'" class="jobs" style="color:rgb(0,0,0);"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><i class="fa fa-map float-right"></i><span>'+task.jobname+'</span></li></a>');
            });
            $tasks.append('<input type="hidden" value="'+tasks.meta.current_page+'" id="cur_page">')
        }
    });
});
$(window).scroll(function () {
    if ($(document).height() <= $(window).scrollTop() + $(window).height()) {
        var $tasks = $('#tasks');
        var cur_page = $('#cur_page');
        $.ajax({
            type:'GET',
            url:'/api/tasks',
            data: { 
                "page": parseInt(cur_page.val())+1
            },
            success:function(tasks){
                
                console.log(tasks);
                $.each(tasks.data,function(i,task){
                    $tasks.append('<a href="tasks/'+task.id+'" class="jobs" style="color:rgb(0,0,0);"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><i class="fa fa-map float-right"></i><span>'+task.jobname+'</span></li></a>');
                });
                cur_page.val(tasks.meta.current_page);
            }
        });
    }
});
$(function(){
    var $tasks = $('#tasks');
    $.ajax({
        type:'GET',
        url:'/api/tasks',
        success:function(tasks){     
            $tasks.append('<input type="hidden" value="'+tasks.meta.current_page+'" id="cur_page">')
            $.each(tasks.data,function(i,task){
                $tasks.append('<a href="tasks/'+task.id+'" class="jobs" style="color:rgb(0,0,0);"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><i class="fa fa-map float-right"></i><span>'+task.jobname+'</span></li></a>');
            });
        }
    });
});

