<?php
namespace App\DataTables;
use App\Models\BFOTPlan;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class UserBFOTPlansDataTable extends DataTable
{
    	

    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
		->addColumn('num_refs', function ($bfot_plan_for_this_user) {
			return $bfot_plan_for_this_user->users()->find(auth()->user()->id)->referrals()->count();	
		})
		->addColumn('bfot_revenue', function ($bfot_plan_for_this_user) {
			return $bfot_plan_for_this_user->users()->find(auth()->user()->id)->bfot_revenue($bfot_plan_for_this_user);	
		})
   		->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
		   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox',]);
    }
 
	public function query()
    {
		if (auth()->user()){
			$bfotplans = BFOTPlan::all();
			//Get VotePlan's user
              foreach($bfotplans as $bfotplan)
              	if ($bfotplan->users->find(auth()->user()->id))
					return BFOTPlan::query()->select("b_f_o_t_plans.*")->where('id', $bfotplan->id);

		}
        //return BFOTPlan::query()->select("b_f_o_t_plans.*");

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
					],	
                ],
                'initComplete' => "function () {


            
            ". filterElement('1,2,3,4,5', 'input') . "

            

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
                'title' => trans('user.record_id'),
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
				[
                 'name'=>'type',
                 'data'=>'type',
                 'title'=>trans('user.type'),
		    ],
				[
                 'name'=>'description',
                 'data'=>'description',
                 'title'=>trans('user.description'),
		    ],
				[
                 'name'=>'num_of_refs_cond',
                 'data'=>'num_of_refs_cond',
                 'title'=>trans('user.num_of_refs_cond'),
		    ],
			[
				'name'=>'kuro_balance_cond',
				'data'=>'kuro_balance_cond',
				'title'=>trans('user.kuro_balance_cond'),
		   ],
				[
                 'name'=>'revenue',
                 'data'=>'revenue',
                 'title'=>trans('user.revenue'),
		    ],
			[
				'name'=>'num_refs',
				'data'=>'num_refs',
				'title'=>trans('user.num_refs'),
		   ],
		   [
			'name'=>'bfot_revenue',
			'data'=>'bfot_revenue',
			'title'=>trans('user.bfot_revenue'),
	   	],
		   [
			'name'=>'num_paid_refs',
			'data'=>'num_paid_refs',
			'title'=>trans('admin.num_paid_refs'),
		],
		[
			'name'=>'paid_bfot_plan_balance',
			'data'=>'paid_bfot_plan_balance',
			'title'=>trans('admin.paid_bfot_plan_balance'),
		],
           
    	 ];
			}


	protected function filename()
	    {
	        return 'bfotplans_' . time();
	    }
    	
}