

<!-- jQuery -->
<script type="text/javascript" src="{{asset('plugins/jquery/jquery-3.3.1.js')}}" ></script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- DataTables -->
<script type="text/javascript" src="{{asset('plugins/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/Responsive-2.2.3/js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/FixedColumns-3.3.0/js/dataTables.fixedColumns.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/JSZip-2.5.0/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/Buttons-1.6.0/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/Buttons-1.6.0/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/DataTables/RowGroup-1.1.1/js/dataTables.rowGroup.min.js')}}"></script>
 
<!-- Highcharts 
<script type="text/javascript" src="{{asset('plugins/highcharts/highcharts.js')}}"></script>-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/item-series.js"></script>
<script src="https://code.highcharts.com/modules/pattern-fill.js"></script>
 
<!-- Select2 -->
<script type="text/javascript" src="{{asset('plugins/select2/js/select2.min.js')}}"></script>

<!-- Custom Javascript -->
<script src="{{ asset('js/smaug.js').'?'.date('ymdHi', filemtime(public_path('js/smaug.js')))  }}"></script>
<script src="{{ asset('js/accounts.js').'?'.date('ymdHi', filemtime(public_path('js/accounts.js')))  }}"></script>