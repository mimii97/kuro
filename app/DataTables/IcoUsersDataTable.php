<?php
namespace App\DataTables;
use App\Models\IcoUser;
use App\Models\User;
use App\Models\ICO;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\URL;

class IcoUsersDataTable extends DataTable
{

    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
            ->addColumn('actions', 'admin.icousers.buttons.actions')
			->addColumn('user_name', function ($comments) {
				return "<a href=users/".User::find($comments->user_id)->id. ">".User::find($comments->user_id)->user_name."</a>";	
			})
			->addColumn('i_c_o_id', function ($comments) {
				return "<a href=icos/".$comments->i_c_o_id. ">".$comments->i_c_o_id."</a>";	
			})
            ->addColumn('status', '{{ trans("admin.".$status) }}')

            ->addColumn('purchase_method', '{{ trans("admin.".$purchase_method) }}')

   		->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox','actions','user_name','i_c_o_id',]);
    }
  

	public function query()
    {
        return IcoUser::query()->select("ico_users.*");

    }
    	

    public function html()
	    {
	      $html =  $this->builder()
            ->columns($this->getColumns())
            //->ajax('')
            ->parameters([
               'searching'   => true,
               'paging'   => true,
               'bLengthChange'   => true,
               'bInfo'   => true,
               'responsive'   => true,
                'dom' => 'Blfrtip',
                "lengthMenu" => [[10, 25, 50,100, -1], [10, 25, 50,100, trans('admin.all_records')]],
                'buttons' => [
                	[
					  'extend' => 'print',
					  'className' => 'btn btn-outline',
					  'text' => '<i class="fa fa-print"></i> '.trans('admin.print')
					 ],	[
					'extend' => 'excel',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-file-excel"> </i> '.trans('admin.export_excel')
					],	[
					'extend' => 'csv',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-file-excel"> </i> '.trans('admin.export_csv')
					],	[
					 'extend' => 'pdf',
					 'className' => 'btn btn-outline',
					 'text' => '<i class="fa fa-file-pdf"> </i> '.trans('admin.export_pdf')
					],	[
					'extend' => 'reload',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-sync-alt"></i> '.trans('admin.reload')
					],	[
						'text' => '<i class="fa fa-trash"></i> '.trans('admin.delete'),
						'className'    => 'btn btn-outline deleteBtn',
                    ], 	[
                        'text' => '<i class="fa fa-plus"></i> '.trans('admin.add'),
                        'className'    => 'btn btn-primary',
                        'action'    => 'function(){
                        	window.location.href =  "'.URL::current().'/create";
                        }',
                    ],
                ],
                'initComplete' => "function () {


            
            ". filterElement('2,4,5,', 'input') . "

            //statusamount,status,purchase_method,user_id,i_c_o_id3
            ". filterElement('7', 'select', [
            'joined'=>trans('admin.joined'),
            'pending'=>trans('admin.pending'),
            ]) . "
            //purchase_methodamount,status,purchase_method,user_id,i_c_o_id4
            ". filterElement('6', 'select', [
            'pancakeswap'=>trans('admin.pancakeswap'),
            'indoex'=>trans('admin.indoex'),
            'kuro_team'=>trans('admin.kuro_team'),
            ]) . "


	            }",
                'order' => [[1, 'desc']],

                    'language' => [
                       'sProcessing' => trans('admin.sProcessing'),
							'sLengthMenu'        => trans('admin.sLengthMenu'),
							'sZeroRecords'       => trans('admin.sZeroRecords'),
							'sEmptyTable'        => trans('admin.sEmptyTable'),
							'sInfo'              => trans('admin.sInfo'),
							'sInfoEmpty'         => trans('admin.sInfoEmpty'),
							'sInfoFiltered'      => trans('admin.sInfoFiltered'),
							'sInfoPostFix'       => trans('admin.sInfoPostFix'),
							'sSearch'            => trans('admin.sSearch'),
							'sUrl'               => trans('admin.sUrl'),
							'sInfoThousands'     => trans('admin.sInfoThousands'),
							'sLoadingRecords'    => trans('admin.sLoadingRecords'),
							'oPaginate'          => [
								'sFirst'            => trans('admin.sFirst'),
								'sLast'             => trans('admin.sLast'),
								'sNext'             => trans('admin.sNext'),
								'sPrevious'         => trans('admin.sPrevious'),
							],
							'oAria'            => [
								'sSortAscending'  => trans('admin.sSortAscending'),
								'sSortDescending' => trans('admin.sSortDescending'),
							],
                    ]
                ]);

        return $html;

	    }


	protected function getColumns()
	    {
	        return [
	       	
 			[
                'name' => 'checkbox',
                'data' => 'checkbox',
                'title' => '<div  class="icheck-danger">
                  <input type="checkbox" class="select-all" id="select-all"  onclick="select_all()" >
                  <label for="select-all"></label>
                </div>',
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => false,
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
			[
                'name' => 'id',
                'data' => 'id',
                'title' => trans('admin.record_id'),
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
			'user_name' => [
				'name' => 'user_name',
				'data' => 'user_name'
				
			],
			
				[
                 'name'=>'user_id',
                 'data'=>'user_id',
				 'visible' => false,
                 'title'=>trans('admin.user_id'),
		    ],
				[
                 'name'=>'i_c_o_id',
                 'data'=>'i_c_o_id',
                 'title'=>trans('admin.i_c_o_id'),
		    ],
				[
                 'name'=>'amount',
                 'data'=>'amount',
                 'title'=>trans('admin.amount'),
		    ],
				[
                 'name'=>'ico_users.status',
                 'data'=>'status',
                 'title'=>trans('admin.status'),
		    ],
				[
                 'name'=>'ico_users.purchase_method',
                 'data'=>'purchase_method',
                 'title'=>trans('admin.purchase_method'),
		    ],
			
            [
	                'name' => 'created_at',
	                'data' => 'created_at',
	                'title' => trans('admin.created_at'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
	            ],
	                    [
	                'name' => 'updated_at',
	                'data' => 'updated_at',
	                'title' => trans('admin.updated_at'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
	            ],
	                    [
	                'name' => 'actions',
	                'data' => 'actions',
	                'title' => trans('admin.actions'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
	            ],
    	 ];
			}

	protected function filename()
	    {
	        return 'icousers_' . time();
	    }
    	
}