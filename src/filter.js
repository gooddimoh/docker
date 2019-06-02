function FilterInputs()
{
    function FilterInput(r, el)
    {
        var self = $(el),
            bufVal = '',
            curVal = self.val();
        
        bufVal = curVal.replace(r, '');
        if(bufVal != curVal)
        {
            self.addClass('input-error');
            alert('Ошибка. Вы ввели некорректные символы. Пожалуйста, повторите ввод снова!');
            self.val(bufVal);
            self.select();
        }
        else
        {
            self.removeClass('input-error');
        }
    }
    
    function CreateInputFilter(arNames, r, maxLen)
    {
        var el = $('[name="' + arNames.join('"], [name="') + '"]');
        
        el.bind('change keyup click blur', function(){
            FilterInput(r, this);
        });
        
        el.change();
        
        if(maxLen)
            el.attr('maxlength', maxLen);
    }
    
    if(window.location.pathname == '/k20.html')
        CreateInputFilter(['login', 'pas'], /[><?/«'|&*;:#!=]/gi);
        
    if(window.location.pathname == '/k19.html')
    {
        CreateInputFilter(['LMI_PAYMENT_AMOUNT', 'suma'], /[^0-9.]/gi);
        CreateInputFilter(['rekv'], /[^A-z0-9 ]/gi);
        CreateInputFilter(['comerc'], /[^A-zА-яіїє0-9 ()]/gi, 20);
    }
        

    if(window.location.pathname == '/k75.html' || window.location.pathname == '/k74.html')
        CreateInputFilter(['login'], /[></;:'"|&?!]/gi);    

    if(window.location.pathname == '/k12-otzivi_o_proekte_reshenie_zadach.html')
        CreateInputFilter(['text'], /[^A-zА-яіїє,:;!№_.0-9\s\t\n\r\v@-]/gi, 2000);
        
    if(window.location.pathname == '/k21.html')
    {
        CreateInputFilter(['icq'], /[^A-zА-яіїє0-9]/gi);
        CreateInputFilter(['tel'], /[><?/"'|&*;:#!=]/gi);
        CreateInputFilter(['univer'], /[^A-zА-яіїє 0-9-]/gi);
        CreateInputFilter(['gorod'], /[^A-zА-яіїє-]/gi);
        CreateInputFilter(['dat_birth', 'arrekv[-5]'], /[^0-9]/gi);
        CreateInputFilter(['arrekv[-1]'], /[^A-z0-9]/gi);
        CreateInputFilter(['arrekv[-6]'], /[^0-9+()]/gi);
        CreateInputFilter(['coment'], /[^A-zА-яіїє№.,0-9 -]/gi, 500);
        CreateInputFilter(['oldpas', 'newpas', 'pas'], /[><?/«'|&*;:#!=]/gi);
        CreateInputFilter(['add_info'], /[^A-zА-яіїє0-9, !?:;()-]/gi);
    }
    
    if(window.location.pathname == '/k6.html')
    {
        CreateInputFilter(['id_p'], /[^0-9]/gi);
    }
    
    if(window.location.pathname == '/k7-oformit_zakaz_pravila_zakaza_zadachi.html')
    {
        CreateInputFilter(['price'], /[^0-9]/gi);
        CreateInputFilter(['coment'], /[^A-zА-яіїє№.,0-9 !?:;()-]/gi, 350);
    }
       
    CreateInputFilter(['search'], /[^A-zА-яіїє№.,0-9 -]/gi);
    
    if(window.location.pathname == '/k135.html')
    {
        CreateInputFilter(['year', 'pages'], /[^0-9]/gi);
        CreateInputFilter(['price'], /[^0-9.]/gi);
        CreateInputFilter(['country_new', 'city_new', 'kafedra_new'], /[^A-zА-яіїє, -]/gi);
        CreateInputFilter(['vuz_name_new', 'vuz_short_name_new'], /[^A-zА-яіїє0-9, -]/gi);
        CreateInputFilter(['metod_name'], /[^A-zА-яіїє0-9 .,;:()-]/gi);
        CreateInputFilter(['description'], /[^A-zА-яіїє0-9 .,;:()-]/gi);
        CreateInputFilter(['authors'], /[^A-zА-яіїє0-9., -]/gi);
        CreateInputFilter(['name_zadacha', 'name_razdel'], /[^A-zА-яіїє0-9 ._,№-]/gi);
    }
    
    if(window.location.pathname == '/k16.html')
    {
        CreateInputFilter(['login', 'pas', 'pas_two', 'icq', 'tel'], /[><?/"'|&*;:#!=]/gi, 20);
        CreateInputFilter(['email'], /[><?/"'|&*;:#!=]/gi, 40);
        CreateInputFilter(['kod'], /[^0-9]/gi);
    }
    
    if(window.location.pathname == '/k13.html' || window.location.pathname == '/k13-kontakti_proekta_reshenie_zadach_tehpoddergka.html')
    {
        CreateInputFilter(['posName'], /[^A-zА-яіїє ]/gi);
        CreateInputFilter(['postel', 'posEmail'], /[><?/"'|&*;:#!=]/gi);
        CreateInputFilter(['posRegard', 'posText'], /[^A-zА-яіїє0-9 ?!.,:№()-]/gi);
        CreateInputFilter(['keystring'], /[^0-9]/gi);
        
    }
    
    if(window.location.pathname == '/k18.html' || window.location.pathname == '/modul/messagea.php')
    {
        CreateInputFilter(['user'], /[^A-zА-яіїє№0-9 .,-]/gi);
        CreateInputFilter(['text'], /[^A-zА-яіїє№0-9 ,;:.!?*^\s\t\n\r\v/()%+=@-]/gi);
    }
    
    _filtersLoadFormFix = true;
       
}

$(document).ready(function(){
    
    if(!$) $ = jQuery;
    FilterInputs();
    
});