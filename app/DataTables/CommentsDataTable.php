<?php
namespace App\DataTables;
use App\Models\Comment;
use App\Models\User;
use App\Models\Blog;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class CommentsDataTable extends DataTable
{

    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
            ->addColumn('actions', 'admin.comments.buttons.actions')
			->addColumn('user', function ($comments) {
				return "<a href=users/".User::find($comments->user_id)->id. ">".User::find($comments->user_id)->user_name."</a>";	
			})
			->addColumn('blog', function ($comments) {
				return "<a href=blogs/".$comments->blog_id. ">".Blog::find($comments->blog_id)->title."</a>";	
			})
				
   			->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
		   	->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
			->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox','actions','user', 'blog']);
    }
 
	public function query()
    {
		//Get user name of the comment's 
		$comments = Comment::all();
        foreach ($comments as $comment) {
            $comment->user_name = $comment->user->name;
        }

        return $comments;
        return Comment::query()->select("comments.*");

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
		
			'user' => [
				'name' => 'user',
				'data' => 'user',
				'title'=>trans('admin.user_name')
			],
			'blog' => [
				'name' => 'blog',
				'data' => 'blog',
				'title'=>trans('admin.blog_title')
			],
			
				[
                 'name'=>'user_id',
                 'data'=>'user_id',
                 'title'=>trans('admin.user_id'),
		    ],
				[
                 'name'=>'blog_id',
                 'data'=>'blog_id',
                 'title'=>trans('admin.blog_id'),
		    ],
			[
				'name'=>'content',
				'data'=>'content',
				'title'=>trans('admin.content'),
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
	        return 'comments_' . time();
	    }
    	
}