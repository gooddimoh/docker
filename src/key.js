$().ready(function() { $(".cost").keypress(function (e)
	 {
        if( e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
		{
        return false;
		}
	});
});

$().ready(function() { $(".number").keypress(function (e)
	 {
        if( e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) )
		{
        return false;
		}
	});
});