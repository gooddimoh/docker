var cur_visible = -1;
var cur_visible_id = -1;
var tmr;
var tmrr;
function usr_vis(id,num)
{
   if (id == cur_visible && num == cur_visible_id) return;
   clearTimeout(tmrr);
   tmrr = setTimeout(function(){
            
           if (cur_visible > -1) 
            if (cur_visible != id)
            {
              $('#userinfo1_'+cur_visible).css('display', 'none'); 
              $('#userinfo2_'+cur_visible).css('display', 'none'); 
            }
            
            cur_visible = id; 
            cur_visible_id = num;
            
            if (cur_visible_id == 1)
            $('#userinfo2_'+cur_visible).css('display', 'none');
            else $('#userinfo1_'+cur_visible).css('display', 'none');
            $('#userinfo'+num+'_'+id).css('display', 'block');
           
    },500);
}
function usr_hide(id,num)
{
       clearTimeout(tmr);
       tmr = setTimeout(function(){
            $('#userinfo'+num+'_'+id).css('display', 'none'); 
            cur_visible = 0;
       
       },500);
}
function noShow()
{
    clearTimeout(tmrr);
}

var first_razdel_change = true;
var last_podrazdel = 0;
function razdel_change()
{
    if (first_razdel_change)
    {
        first_razdel_change = false;
        $("#s_razdel :first").remove();
        $("#s_podrazdel").css("display","table-row");
    }
    
    if (last_podrazdel > 0) 
    {
        $("#s_podrazdel_" + last_podrazdel).attr("disabled","true");
        $("#s_podrazdel_" + last_podrazdel).css("display","none");
    }
    last_podrazdel = $("#s_razdel option:selected").val();
    $("#s_podrazdel_" + last_podrazdel).attr("disabled","");
    $("#s_podrazdel_" + last_podrazdel).css("display","inline");
    
}


function recalculate_price(from,to,stavka)
{
    from.value.replace(/D/g, '');
    var zr = from.value * stavka / 100;
    if (zr < 1) zr = ''; else zr = zr + ' RUR';
    $('#'+to).html(zr);
}

function balanceTablesorterInit()
{
    $.tablesorter.addParser({ 
            id: "eudate", 
            is: function(s) { 
                return false; 
            }, 
            format: function(s,table) { 
                s = s.replace(/\-/g,"/"); 
                s = s.replace(/(\d{2})[\/\.](\d{2})[\/\.](\d{2}) (\d{2}):(\d{2})/, "$3-$2-$1 $4:$5");                            
                return $.tablesorter.formatFloat(new Date(s).getTime()); 
            }, 
            type: "numeric" 
         });
    
    $("#table-sort-1").tablesorter({
        
        debug: false,
        headers: {1:{sorter:"eudate"}, 3:{sorter:"text"}},
        
        textExtraction: function(node){
            return node.childNodes[0].innerHTML;
        }
        
    });
}

function balanceTablesorterFilterType(filter)
{
    $('[data-table-filter-type]').each(function(){
        
        var self = $(this);
        
        if(!filter || self.html() == filter)
            self.parents('tr:first').show();
        else
            self.parents('tr:first').hide();
        
    });
}