<?php
namespace App\DataTables;
use App\Models\User;
use App\Models\VotePlan;
use App\Models\BFOTPlan;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\URL;

class UsersDataTable extends DataTable
{

    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
            ->addColumn('actions', 'admin.users.buttons.actions')
			->addColumn('vote_plan_id', function ($user) {
				return "<a href=voteplans/".$user->vote_plan_id. ">".VotePlan::find($user->vote_plan_id)->type."</a>";	
			})

			->addColumn('b_f_o_t_plan_id', function ($user) {
				return "<a href=bfotplans/".$user->b_f_o_t_plan_id. ">".BFOTPlan::find($user->b_f_o_t_plan_id)->type."</a>";	
			})

			->addColumn('vote_revenue', function ($user) {
				return $user->vote_revenue(VotePlan::query()->select("vote_plans.*")->where('id', $user->vote_plan_id)->firstOrFail());	
			})

			->addColumn('bfot_revenue', function ($user) {
				return $user->bfot_revenue(BFOTPlan::query()->select("b_f_o_t_plans.*")->where('id', $user->b_f_o_t_plan_id)->firstOrFail());	
			})

   		->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox','actions','vote_plan_id', 'b_f_o_t_plan_id']);
    }
  

	public function query()
    {
        return User::query()->select("users.*");

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


            
            ". filterElement('1,2,3,4,5,6,9,10,11', 'input') . "

            

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
				[
                 'name'=>'name',
                 'data'=>'name',
                 'title'=>trans('admin.name'),
		    ],
				[
                 'name'=>'email',
                 'data'=>'email',
                 'title'=>trans('admin.email'),
		    ],
				[
                 'name'=>'user_name',
                 'data'=>'user_name',
                 'title'=>trans('admin.user_name'),
		    ],
				[
                 'name'=>'age',
                 'data'=>'age',
                 'title'=>trans('admin.age'),
		    ],
				
				[
                 'name'=>'vote_plan_id',
                 'data'=>'vote_plan_id',
                 'title'=>trans('admin.vote_plan_id'),
		    ],
				[
                 'name'=>'vote_revenue',
                 'data'=>'vote_revenue',
                 'title'=>trans('admin.vote_revenue'),
		    ],
			[
				'name'=>'b_f_o_t_plan_id',
				'data'=>'b_f_o_t_plan_id',
				'title'=>trans('admin.b_f_o_t_plan_id'),
			],
			[
				'name'=>'bfot_revenue',
				'data'=>'bfot_revenue',
				'title'=>trans('admin.bfot_revenue'),
			],
			[
                 'name'=>'kuro_balance',
                 'data'=>'kuro_balance',
                 'title'=>trans('admin.kuro_balance'),
		    ],
			[
				'name'=>'num_paid_votes',
				'data'=>'num_paid_votes',
				'title'=>trans('admin.num_paid_votes'),
		   ],
		   [
				'name'=>'paid_vote_plan_balance',
				'data'=>'paid_vote_plan_balance',
				'title'=>trans('admin.paid_vote_plan_balance'),
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
	        return 'users_' . time();
	    }
    	
}