<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal">
            {{ __('Salestrack') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('admin.dashboard')) ? '' : 'not-access' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @if(Sentinel::getUser())
                <li class="{{ in_array($elementActive, ['masters', 'master_account', 'customer_ledger', 'purchase_ledger', 'general_ledger', 'master_inventory', 'stock_items', 'stock_groups', 'units', 'stock_categories', 'bom', 'batches', 'transporter', 'warehouse'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['masters.account','groups.index','masters.ledger','customer-groups.index','supplier-groups.index','inventory.index','stock-items.index','stock-groups.index','units.index','stock-categories.index','bom.index','batches.index','transporter.index'])) ? '' : 'not-access' }}">
                    <a data-toggle="collapse" aria-expanded="true" href="#masters">
                        <i class="nc-icon nc-chart-bar-32"></i>
                        <p>
                            {{ __('Masters') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse sub_tree {{ \Helper::isMenuOpen(['masters', 'units', 'warehouses']) }}" id="masters">
                        <ul class="nav">
                            <li class="{{ in_array($elementActive, ['master_account']) ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['masters.account','groups.index','masters.ledger','customer-groups.index','supplier-groups.index','sales.index','purchase.index','general.index'])) ? '' : 'not-access' }}">
                                <a data-toggle="collapse" aria-expanded="true" href="#masters_account">
                                    <i class="nc-icon nc-ruler-pencil"></i>
                                    <p>
                                        {{ __(' Accounts Info. ') }}
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['ledger', 'account', 'account/groups', 'customer-groups', 'supplier-groups']) }}" id="masters_account">
                                    <ul class="nav">
                                        <li class="{{ in_array($elementActive, ['ledgers']) ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['sales.index','purchase.index','general.index'])) ? '' : 'not-access' }}">
                                            <a data-toggle="collapse" aria-expanded="true" href="#masters_account_ledger">
                                                <i class="nc-icon nc-box"></i>
                                                <p>
                                                    {{ __(' Ledgers ') }}
                                                    <b class="caret"></b>
                                                </p>
                                            </a>
                                            <div class="collapse sub_tree show" id="masters_account_ledger">
                                                <ul class="nav">
                                                    <li class="{{ $elementActive == 'customer_ledger' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('sales.index')) ? '' : 'not-access' }}">
                                                        <a href="{{ route('sales.index') }}">
                                                            <i class="nc-icon nc-align-center"></i>
                                                            <span class="sidebar-normal">{{ __(' Customers ') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="{{ $elementActive == 'purchase_ledger' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase.index')) ? '' : 'not-access' }}">
                                                        <a href="{{ route('purchase.index') }}">
                                                            <i class="nc-icon nc-align-center"></i>
                                                            <span class="sidebar-normal">{{ __(' Suppliers ') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="{{ $elementActive == 'general_ledger' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('general.index')) ? '' : 'not-access' }}">
                                                        <a href="{{ route('general.index') }}">
                                                            <i class="nc-icon nc-align-center"></i>
                                                            <span class="sidebar-normal">{{ __(' General ') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="{{ $elementActive == 'account_groups' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('groups.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('groups.index') }}">
                                                <i class="nc-icon nc-credit-card"></i>
                                                <span class="sidebar-normal">{{ __(' Account Groups ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'customer_groups' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('customer-groups.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('customer-groups.index') }}">
                                                <i class="nc-icon nc-chart-pie-36"></i>
                                                <span class="sidebar-normal">{{ __(' Customer Groups ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'supplier_groups' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('supplier-groups.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('supplier-groups.index') }}">
                                                <i class="nc-icon nc-delivery-fast"></i>
                                                <span class="sidebar-normal">{{ __(' Supplier Groups ') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="{{ in_array($elementActive, ['master_inventory']) ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['stock-items.index', 'stock-groups.index', 'units.index', 'stock-categories.index', 'bom.index', 'batches.index'])) ? '' : 'not-access' }}">
                                <a data-toggle="collapse" aria-expanded="true" href="#masters_inventory">
                                    <i class="nc-icon nc-paper"></i>
                                    <p>
                                        {{ __(' Inventory Info. ') }}
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['stock-items', 'stock-groups', 'units', 'stock-categories', 'bom', 'batches']) }}" id="masters_inventory">
                                    <ul class="nav">
                                        <li class="{{ $elementActive == 'stock_items' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('stock-items.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('stock-items.index') }}">
                                                <i class="nc-icon nc-box"></i>
                                                <span class="sidebar-normal">{{ __(' Stock Item ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'stock_groups' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('stock-groups.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('stock-groups.index') }}">
                                                <i class="nc-icon nc-basket"></i>
                                                <span class="sidebar-normal">{{ __(' Stock Group ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'units' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('units.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('units.index') }}">
                                                <i class="nc-icon nc-ruler-pencil"></i>
                                                <span class="sidebar-normal">{{ __(' Unit ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'stock_categories' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('stock-categories.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('stock-categories.index') }}">
                                                <i class="nc-icon nc-bullet-list-67"></i>
                                                <span class="sidebar-normal">{{ __(' Stock Categories ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'bom' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('bom.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('bom.index') }}">
                                                <i class="nc-icon nc-air-baloon"></i>
                                                <span class="sidebar-normal">{{ __(' BOM ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'batches' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('batches.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('batches.index') }}">
                                                <i class="nc-icon nc-align-center"></i>
                                                <span class="sidebar-normal">{{ __(' Batches ') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="{{ $elementActive == 'transporter' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('transporter.index')) ? '' : 'not-access' }}" >
                                <a href="{{ route('transporter.index') }}">
                                    <i class="nc-icon nc-delivery-fast"></i>
                                    <span class="sidebar-normal">{{ __(' Transporter ') }}</span>
                                </a>
                            </li>
                            <li class="{{ $elementActive == 'warehouse' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('warehouses.index')) ? '' : 'not-access' }}">
                                <a href="{{ route('warehouses.index') }}">
                                    <i class="nc-icon nc-layout-11"></i>
                                    <span class="sidebar-normal">{{ __(' Warehouse ') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="{{ in_array($elementActive, ['transaction_purchase', 'materials', 'purchase_order', 'purchase_receipt', 'purchase_invoice', 'purchase_return', 'transaction_sales', 'quotation', 'sales_order', 'delivery_note', 'sales_invoice', 'sales_return'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['transactions.purchase', 'transactions.sales','materials.index','purchase-order.index','purchase-receipt.index','purchase-invoice.index','purchase-return.index','quotation.index','sales-order.index','delivery-note.index','sales-invoice.index','sales-return.index'])) ? '' : 'not-access' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#transactions">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>
                        {{ __('Transactions') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse sub_tree {{ \Helper::isMenuOpen('transactions') }}" id="transactions">
                    <ul class="nav">
                        @if(\Helper::userHasMenuAccess(['transactions.purchase','materials.index','purchase-order.index','purchase-receipt.index','purchase-invoice.index','purchase-return.index']))
                            <li class="{{ in_array($elementActive, ['transaction_purchase', 'materials', 'purchase_order', 'purchase_receipt', 'purchase_invoice', 'purchase_return']) ? 'active' : '' }}">
                                <a data-toggle="collapse" aria-expanded="true" href="#transaction_purchase">
                                    <i class="nc-icon nc-credit-card"></i>
                                    <p>
                                        {{ __(' Purchase ') }}
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['transactions/purchase']) }}" id="transaction_purchase">
                                    <ul class="nav">
                                        <li class="{{ $elementActive == 'materials' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('materials.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('materials.index') }}">
                                                <i class="nc-icon nc-box"></i>
                                                <span class="sidebar-normal">{{ __(' Material Request ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'purchase_order' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase-order.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('purchase-order.index') }}">
                                                <i class="nc-icon nc-basket"></i>
                                                <span class="sidebar-normal">{{ __(' Purchase Orders ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'purchase_receipt' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase-receipt.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('purchase-receipt.index') }}">
                                                <i class="nc-icon nc-ruler-pencil"></i>
                                                <span class="sidebar-normal">{{ __(' Purchase Reciepts ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'purchase_invoice' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase-invoice.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('purchase-invoice.index') }}">
                                                <i class="nc-icon nc-bullet-list-67"></i>
                                                <span class="sidebar-normal">{{ __(' Purchase Invoice ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'purchase_return' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase-return.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('purchase-return.index') }}">
                                                <i class="nc-icon nc-air-baloon"></i>
                                                <span class="sidebar-normal">{{ __(' Purchase Return ') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if(\Helper::userHasMenuAccess(['transactions.sales','quotation.index','sales-order.index','delivery-note.index','sales-invoice.index','sales-return.index']))
                            <li class="{{ in_array($elementActive, ['transaction_sales', 'quotation', 'sales_order', 'delivery_note', 'sales_invoice', 'sales_return']) ? 'active' : '' }}">
                                <a data-toggle="collapse" aria-expanded="true" href="#transaction_sales">
                                    <i class="nc-icon nc-calendar-60"></i>
                                    <p>
                                        {{ __(' Sales ') }}
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['transactions/sales']) }}" id="transaction_sales">
                                    <ul class="nav">
                                        <li class="{{ $elementActive == 'quotation' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('quotation.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('quotation.index') }}">
                                                <i class="nc-icon nc-box"></i>
                                                <span class="sidebar-normal">{{ __(' Quotation ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'sales_order' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('sales-order.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('sales-order.index') }}">
                                                <i class="nc-icon nc-basket"></i>
                                                <span class="sidebar-normal">{{ __(' Sales Orders ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'delivery_note' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('delivery-note.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('delivery-note.index') }}">
                                                <i class="nc-icon nc-ruler-pencil"></i>
                                                <span class="sidebar-normal">{{ __(' Delivery Note ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'sales_invoice' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('sales-invoice.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('sales-invoice.index') }}">
                                                <i class="nc-icon nc-bullet-list-67"></i>
                                                <span class="sidebar-normal">{{ __(' Sales Invoice ') }}</span>
                                            </a>
                                        </li>
                                        <li class="{{ $elementActive == 'sales_return' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('sales-return.index')) ? '' : 'not-access' }}">
                                            <a href="{{ route('sales-return.index') }}">
                                                <i class="nc-icon nc-air-baloon"></i>
                                                <span class="sidebar-normal">{{ __(' Sales Return ') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'stock_transfer' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('stocks.index')) ? '' : 'not-access' }}">
                <a href="{{ route('stocks.index') }}">
                    <i class="nc-icon nc-share-66"></i>
                    <p>{{ __('Stock Transfer') }}</p>
                </a>
            </li>
            <li class="{{ in_array($elementActive, ['production_plan', 'workorder'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['production-plan.index', 'work-order.index'])) ? '' : 'not-access' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#manufacturing">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>
                        {{ __('Manufacturing') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse sub_tree {{ \Helper::isMenuOpen('manufacturing') }}" id="manufacturing">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'production_plan' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('production-plan.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('production-plan.index') }}">
                                <i class="nc-icon nc-sound-wave"></i>
                                <span class="sidebar-normal">{{ __(' Production Plan ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'workorder' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('work-order.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('work-order.index') }}">
                                <i class="nc-icon nc-send"></i>
                                <span class="sidebar-normal">{{ __(' Workorder ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ in_array($elementActive, ['qc_report', 'qc_tests'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['qc-report.index', 'qc-tests.index'])) ? '' : 'not-access' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#qc_tab">
                    <i class="nc-icon nc-tablet-2"></i>
                    <p>
                        {{ __('QC') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['qc-report', 'qc-tests']) }}" id="qc_tab">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'qc_report' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('qc-report.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('qc-report.index') }}">
                                <i class="nc-icon nc-tag-content"></i>
                                <span class="sidebar-normal">{{ __(' QC Report ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'qc_tests' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('qc-tests.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('qc-tests.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __(' QC Tests. ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ in_array($elementActive, ['stock_ledger_report', 'payment_report', 'sales_report', 'purchase_report'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['stock-ledger.index', 'payment-report.index', 'sales-report.index', 'purchase-report.index'])) ? '' : 'not-access' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#reports">
                    <i class="nc-icon nc-tablet-2"></i>
                    <p>
                        {{ __('Reports') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse sub_tree {{ \Helper::isMenuOpen('reports') }}" id="reports">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'stock_ledger_report' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('stock-ledger.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('stock-ledger.index') }}">
                                <i class="nc-icon nc-tag-content"></i>
                                <span class="sidebar-normal">{{ __(' Stock Ledger ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'payment_report' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('payment-report.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('payment-report.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __(' Payment Ledger ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'sales_report' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('sales-report.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('sales-report.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __(' Sales Report ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'purchase_report' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('purchase-report.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('purchase-report.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __('Purchase Report') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'payment' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('payments.index')) ? '' : 'not-access' }}">
                <a href="{{ route('payments.index') }}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>{{ __('Payment') }}</p>
                </a>
            </li>
            <li class="{{ in_array($elementActive, ['users', 'roles', 'companies', 'terretory', 'grades', 'departments'])  ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['settings-listing.index', 'users.index', 'roles.index', 'companies.index', 'terretory.index', 'grades.index', 'departments.index'])) ? '' : 'not-access' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#settings">
                    <i class="nc-icon nc-tablet-2"></i>
                    <p>
                        {{ __('Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse sub_tree {{ \Helper::isMenuOpen(['settings', 'users', 'roles', 'companies', 'departments']) }}" id="settings">
                    <ul class="nav">
                        <li class="{{ in_array($elementActive, ['users', 'roles']) ? 'active' : '' }} {{ (\Helper::userHasMenuAccess(['users.index', 'roles.index'])) ? '' : 'not-access' }}">
                            <a data-toggle="collapse" aria-expanded="true" href="#users_setting">
                                <i class="nc-icon nc-paper"></i>
                                <p>
                                    {{ __(' Users setting ') }}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse sub_tree {{ \Helper::isMenuOpen(['users', 'roles']) }}" id="users_setting">
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'users' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('users.index')) ? '' : 'not-access' }}">
                                        <a href="{{ route('users.index') }}">
                                            <i class="nc-icon nc-box"></i>
                                            <span class="sidebar-normal">{{ __(' Users ') }}</span>
                                        </a>
                                    </li>
                                    <li class="{{ $elementActive == 'roles' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('roles.index')) ? '' : 'not-access' }}">
                                        <a href="{{ route('roles.index') }}">
                                            <i class="nc-icon nc-basket"></i>
                                            <span class="sidebar-normal">{{ __(' Roles ') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="{{ $elementActive == 'companies' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('companies.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('companies.create') }}">
                                <i class="nc-icon nc-tag-content"></i>
                                <span class="sidebar-normal">{{ __(' Company ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'terretory' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('terretory.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('terretory.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __(' Terretories ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'grades' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('grades.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('grades.index') }}">
                                <i class="nc-icon nc-tag-content"></i>
                                <span class="sidebar-normal">{{ __(' Grades ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'departments' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('departments.index')) ? '' : 'not-access' }}">
                            <a href="{{ route('departments.index') }}">
                                <i class="nc-icon nc-zoom-split"></i>
                                <span class="sidebar-normal">{{ __(' Department ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'roles' ? 'active' : '' }} {{ (\Helper::userHasPageAccess('allseries')) ? '' : 'not-access' }}">
                                        <a href="{{ route('allseries') }}">
                                            <i class="nc-icon nc-basket"></i>
                                            <span class="sidebar-normal">{{ __(' Series') }}</span>
                                        </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if(isset($modules_menu) && $modules_menu->isNotEmpty())
                @foreach($modules_menu as $module)
                    <li class="{{ $elementActive == $module->name ? 'active' : '' }}">
                        <a href="{{ route('custom-module.list', $module->slug) }}">
                            <i class="nc-icon nc-map-big"></i>
                            <p>{{ $module->name }}</p>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
