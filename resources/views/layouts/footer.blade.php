@unless(request()->is('list_shipments', 'form_sea_shipment', 'form_air_shipment', 'list_sea_shipment', 'list_air_shipment', 'sea_shipment-edit/*', 'air_shipment-edit/*', 'company','customer', 'shipper', 'ship', 'unit', 'desc', 'banker', 'origin', 
'account', 'state', 'uom', 'list_bill_recap', 'insurance', 'pricelist', 'cas', 'history', 'form_bill_recap', 'form_air_bill_recap', 'bill_recap-edit/*', 'bill_recap-editair/*'))
<footer class="footer py-4  ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-4 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    made with <i class="fa fa-heart"></i> by
                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                    for a better web.
                </div>
            </div>
            <div class="col-lg-3">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Distributed By: ThemeWagon</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
@endif