<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="">
    	<meta name="author" content="">

	    <title>
    		@yield('title')
    	</title>

	    <!-- Bootstrap Core CSS -->
	    {{HTML::style('css/bootstrap.min.css')}}
	    
	    <!-- MetisMenu CSS -->
	    {{HTML::style('css/plugins/metisMenu/metisMenu.min.css')}}

	    <!-- Timeline CSS -->
	    {{HTML::style('css/plugins/timeline.css')}}

	    <!-- Custom CSS -->
	    {{HTML::style('css/sb-admin-2.css')}}

    	<!-- Morris Charts CSS -->
    	{{HTML::style('css/plugins/morris.css')}}

	    <!-- Custom Fonts -->
	    {{HTML::style('font-awesome-4.1.0/css/font-awesome.min.css')}}
	    
	    <style type="text/css">
	    .top-buffer{
	       margin-top:10px;
	       margin-bottom:10px;
	    }
	    </style>
	    
	    <!-- To place CKEditor script -->
	    @yield('ckeditor')
	</head>
	<body>
		<div id="wrapper">
			@yield('navigation')
            
            @yield('content')
		</div>
		
		<!-- jQuery -->
		{{HTML::script('js/jquery.js')}}

    	<!-- Bootstrap Core JavaScript -->
    	{{HTML::script('js/bootstrap.min.js')}}

    	<!-- Metis Menu Plugin JavaScript -->
    	{{HTML::script('js/plugins/metisMenu/metisMenu.min.js')}}
    	
    	<!-- DataTables JavaScript -->
    	{{HTML::script('js/plugins/dataTables/jquery.dataTables.js')}}
    	{{HTML::script('js/plugins/dataTables/dataTables.bootstrap.js')}}

    	<!-- Morris Charts JavaScript -->
    	{{HTML::script('js/plugins/morris/raphael.min.js')}}
    	{{HTML::script('js/plugins/morris/morris.min.js')}}
    	{{HTML::script('js/plugins/morris/morris-data.js')}}

    	<!-- Custom Theme JavaScript -->
    	{{HTML::script('js/sb-admin-2.js')}}
    	
	</body>
</html>