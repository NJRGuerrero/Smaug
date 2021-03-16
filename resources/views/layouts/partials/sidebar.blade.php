<!-- Start: Sidebar -->
<aside id="sidebar_left" class="nano nano-light affix">

	<!-- Start: Sidebar Left Content -->
	<div class="sidebar-left-content nano-content">

		<!-- Start: Sidebar Header -->
		<header class="sidebar-header">

			<!-- Sidebar Widget - Author -->
			<div class="sidebar-widget author-widget">
				<div class="media">
					XXXXXX
				</div>
			</div>

			<!-- Sidebar Widget - Menu (slidedown) -->
			<div class="sidebar-widget menu-widget">
				<div class="row text-center mbn">
					<div class="col-xs-4">
						<a href="dashboard.html" class="text-primary"
							data-toggle="tooltip" data-placement="top" title="Dashboard">
							<span class="glyphicon glyphicon-home"></span>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="pages_messages.html" class="text-info"
							data-toggle="tooltip" data-placement="top" title="Messages">
							<span class="glyphicon glyphicon-inbox"></span>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="pages_profile.html" class="text-alert"
							data-toggle="tooltip" data-placement="top" title="Tasks"> <span
							class="glyphicon glyphicon-bell"></span>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="pages_timeline.html" class="text-system"
							data-toggle="tooltip" data-placement="top" title="Activity">
							<span class="fa fa-desktop"></span>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="pages_profile.html" class="text-danger"
							data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="fa fa-gears"></span>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="pages_gallery.html" class="text-warning"
							data-toggle="tooltip" data-placement="top" title="Cron Jobs">
							<span class="fa fa-flask"></span>
						</a>
					</div>
				</div>
			</div>

			<!-- Sidebar Widget - Search (hidden) -->
			<div class="sidebar-widget search-widget hidden">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-search"></i>
					</span> <input type="text" id="sidebar-search" class="form-control"
						placeholder="Search...">
				</div>
			</div>

		</header>
		<!-- End: Sidebar Header -->

		<!-- Start: Sidebar Menu -->
		<ul class="nav sidebar-menu">
			<li class="sidebar-label pt20">Menú</li>
			<li class="">
                <a href="dashboard.html">
                    <span class="fa fa-home"></span>
                    <span class="sidebar-title">Inicio</span>
                </a>
            </li>

			<li>
                <a href="{{url('myCompany')}}">
                    <span class="fa fa-building-o"></span>
                    <span class="sidebar-title">Mi Empresa</span>
                </a>
            </li>
		
			<li>
                <a href="{{url('users')}}">
                    <span class="fa fa-users"></span>
                    <span class="sidebar-title">Usuarios</span>
                </a>
			</li>
		
			<li>
                <a href="#">
                    <span class="fa fa-user"></span>
                    <span class="sidebar-title">Contactos</span>
                </a>
			</li>
		
			<li>
                <a href="#">
                    <span class="fa fa-briefcase"></span>
                    <span class="sidebar-title">Proyectos</span>
                </a>
			</li>

			<li>
                <a class="accordion-toggle"  href="#">
                    <span class="fa fa-cogs"></span>
                    <span class="sidebar-title">Gestión Net50</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a class="" href="{{url('products')}}">
                            <span class="fa fa-th-list"></span>
                            <span class="sidebar-title">Productos</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="{{url('settings')}}">
                            <span class="fa fa-cog"></span>
                            <span class="sidebar-title">Parametrización</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('companies')}}">
                            <span class="fa fa-building"></span>
                            <span class="sidebar-title">Empresas</span>
                        </a>
                    </li>
                </ul>		
            </li>

			<!-- DIVISIOÓN <li class="sidebar-label pt15">Exclusive Tools</li>-->
			<!-- End: Sidebar Menu '''''''''''''''''''''''''''''''''''''''' -->

				<!-- Start: Sidebar Collapse Button --> <!-- 		<div class="sidebar-toggle-mini"> -->
				<!-- 			<a href="#"> <span class="fa fa-sign-out"></span> --> <!-- 			</a> -->
				<!-- 		</div> --> <!-- End: Sidebar Collapse Button -->
	</div>
	<!-- End: Sidebar Left Content -->

</aside>
<!-- End: Sidebar Left -->