<?php
namespace App\DataTables;
use App\Models\BFOTPlan;
use App\Models\VotePlan;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class UserVotePlansDataTable extends DataTable
{
    	

    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
			->addColumn('num_comments', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->comments()->count('id');	
			})
			->addColumn('num_likes', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->likes()->count('like');	
			})
			->addColumn('num_dislikes', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->dislikes()->count('dislike');	
			})
			->addColumn('vote_revenue', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->vote_revenue($vote_plan_for_this_user);	
			})
			->addColumn('kuro_balance', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->kuro_balance;	
			})

			->addColumn('kuro_balance', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->kuro_balance;	
			})
			->addColumn('kuro_balance', function ($vote_plan_for_this_user) {
				return $vote_plan_for_this_user->users()->find(auth()->user()->id)->kuro_balance;	
			})
   		->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
		   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox','actions',]);
    }
  

	public function query()
    {
		if (auth()->user()){
			$voteplans = VotePlan::all();
              foreach($voteplans as $voteplan)
              	if ($voteplan->users->find(auth()->user()->id))
					return VotePlan::query()->select("vote_plans.*")->where('id', $voteplan->id);

		}
        //return VotePlan::query()->select("vote_plans.*");

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
                'title' => trans('admin.record_id'),
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
				[
                 'name'=>'type',
                 'data'=>'type',
                 'title'=>trans('admin.type'),
		    ],
				[
                 'name'=>'description',
                 'data'=>'description',
                 'title'=>trans('admin.description'),
		    ],
				[
                 'name'=>'num_votes_cond',
                 'data'=>'num_votes_cond',
                 'title'=>trans('admin.num_votes_cond'),
		    ],
			[
				'name'=>'kuro_balance_cond',
				'data'=>'kuro_balance_cond',
				'title'=>trans('admin.kuro_balance_cond'),
		   ],
				[
                 'name'=>'revenue',
                 'data'=>'revenue',
                 'title'=>trans('admin.revenue'),
		    ],
			[
				'name'=>'num_likes',
				'data'=>'num_likes',
				'title'=>trans('user.num_likes'),
		   ],
		   [
			'name'=>'num_dislikes',
			'data'=>'num_dislikes',
			'title'=>trans('user.num_dislikes'),
	   ],

		   [
			'name'=>'num_comments',
			'data'=>'num_comments',
			'title'=>trans('user.num_comments'),
			],
			[
				'name'=>'kuro_balance',
				'data'=>'kuro_balance',
				'title'=>trans('user.kuro_balance'),
			],
			[
				'name'=>'vote_revenue',
				'data'=>'vote_revenue',
				'title'=>trans('user.user_vote_revenue'),
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
            
    	 ];
			}


	protected function filename()
	    {
	        return 'voteplans_' . time();
	    }
    	
}