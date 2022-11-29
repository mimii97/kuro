<?php
namespace App\DataTables;
use App\Models\AdminGroup;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\URL;


class AdminGroupsDataTable extends DataTable {

	public function dataTable(DataTables $dataTables, $query) {
		return datatables($query)
			->addColumn('actions', 'admin.admingroups.buttons.actions')
			->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata" value="{{ $id }}" >
                  <label for="selectdata"></label>
                </div>')
			->rawColumns(['checkbox', 'actions']);
	}


	public function query() {
		return AdminGroup::query()->select("admin_groups.*");

	}

	public function html() {
		$html = $this->builder()
			->columns($this->getColumns())
		//->ajax('')
			->parameters([
				'responsive' => true,
				'dom' => 'Blfrtip',
				"lengthMenu" => [[10, 25, 50, 100, -1], [10, 25, 50, 100, trans('admin.all_records')]],
				'buttons' => [
					['extend' => 'print', 'className' => 'btn dark btn-outline', 'text' => '<i class="fa fa-print"></i> ' . trans('admin.print')],
					['extend' => 'excel', 'className' => 'btn green btn-outline', 'text' => '<i class="fa fa-file-excel"> </i> ' . trans('admin.export_excel')],
					['extend' => 'pdf', 'className' => 'btn red btn-outline', 'text' => '<i class="fa fa-file-pdf"> </i> ' . trans('admin.export_pdf')],
					['extend' => 'csv', 'className' => 'btn purple btn-outline', 'text' => '<i class="fa fa-file-excel"> </i> ' . trans('admin.export_csv')],
					['extend' => 'reload', 'className' => 'btn blue btn-outline', 'text' => '<i class="fa fa-sync-alt"></i> ' . trans('admin.reload')],
					[
						'text' => '<i class="fa fa-trash"></i> ' . trans('admin.delete'),
						'className' => 'btn red btn-outline deleteBtn',
					], [
						'text' => '<i class="fa fa-plus"></i> ' . trans('admin.add'),
						'className' => 'btn btn-primary',
						'action' => 'function(){
                            window.location.href =  "' . URL::current() . '/create";
                        }',
					],
				],
				'initComplete' => "function () {


            " . filterElement('1,2', 'input') . "


            }",
				'order' => [[1, 'desc']],

				'language' => [
					'sProcessing' => trans('admin.sProcessing'),
					'sLengthMenu' => trans('admin.sLengthMenu'),
					'sZeroRecords' => trans('admin.sZeroRecords'),
					'sEmptyTable' => trans('admin.sEmptyTable'),
					'sInfo' => trans('admin.sInfo'),
					'sInfoEmpty' => trans('admin.sInfoEmpty'),
					'sInfoFiltered' => trans('admin.sInfoFiltered'),
					'sInfoPostFix' => trans('admin.sInfoPostFix'),
					'sSearch' => trans('admin.sSearch'),
					'sUrl' => trans('admin.sUrl'),
					'sInfoThousands' => trans('admin.sInfoThousands'),
					'sLoadingRecords' => trans('admin.sLoadingRecords'),
					'oPaginate' => [
						'sFirst' => trans('admin.sFirst'),
						'sLast' => trans('admin.sLast'),
						'sNext' => trans('admin.sNext'),
						'sPrevious' => trans('admin.sPrevious'),
					],
					'oAria' => [
						'sSortAscending' => trans('admin.sSortAscending'),
						'sSortDescending' => trans('admin.sSortDescending'),
					],
				],
			]);

		return $html;

	}


	protected function getColumns() {
		return [
			[
				'name' => 'checkbox',
				'data' => 'checkbox',
				'title' => '<div  class="icheck-danger">
                  <input type="checkbox" class="select-all" id="select-all"  onclick="select_all()" >
                  <label for="select-all"></label>
                </div>',
				'orderable' => false,
				'searchable' => false,
				'exportable' => false,
				'printable' => false,
				'width' => '10px',
				'aaSorting' => 'none',
			], [
				'name' => 'id',
				'data' => 'id',
				'title' => trans('admin.record_id'),
				'width' => '10px',
				'aaSorting' => 'none',
			],
			[
				'name' => 'group_name',
				'data' => 'group_name',
				'title' => trans('admin.group_name'),
			],
			[
				'name' => 'actions',
				'data' => 'actions',
				'title' => trans('admin.actions'),
				'exportable' => false,
				'printable' => false,
				'searchable' => false,
				'orderable' => false,
			],
		];
	}


	protected function filename() {
		return 'admingroups_' . time();
	}

}