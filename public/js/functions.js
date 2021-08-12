setHeaderAjax();

setInterval(refreshToken, 1000*60*30);

function refreshToken() {
    $.get('refreshToken').done(function(data) {
        $('meta[name="csrf-token"]').attr('content', data);
        $('input[name="_token"]').val(data);
        setHeaderAjax();
    });
}

function setHeaderAjax() {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
}

function dataTableClientSide(tableId, tableColumns, fileName, titleFile, orientationPdf, pageSize, openDownload, sameColumnsWidth, header, footer, showLength, showButtons, showInfo, messageTop='', appendInTitle='', method='GET', dataForm='') {
	if(!tableId) {
		tableId = 'my-table';
	}

	fileName = fileName.toLowerCase();
    fileName = fileName.replace(/\s/g, "-");
    titleFile = titleFile.toUpperCase();

    var exportColumns = [];

    if(!tableColumns) {
    	tableColumns = [];
    }
    if(tableColumns.length == 0) {
	    $('#'+tableId+' thead tr th').each(function(index, th) {
	        var data_data = $(th).attr('data-data');

	        var data_export = $(th).attr('data-export');
	        data_export = data_export != undefined ? JSON.parse(data_export.replace(/'/g, '"')) : true;

	        var data_orderable = $(th).attr('data-orderable');
	        data_orderable = data_orderable != undefined ? JSON.parse(data_orderable.replace(/'/g, '"')) : true;

	        var data_searchable = $(th).attr('data-searchable');
	        data_searchable = data_searchable != undefined ? JSON.parse(data_searchable.replace(/'/g, '"')) : true;

	        tableColumns.push({
	            data: data_data,
	            export: data_export,
	            orderable: data_orderable,
	            searchable: data_searchable
	        });

	        if(data_export) {
	        	exportColumns.push(index);
	        }
	    });
	}

	console.log(exportColumns)

    for(var key in tableColumns) {
	    if(tableColumns[key].hasOwnProperty('export')) {
	    	if(tableColumns[key].export === true || tableColumns[key].export.hasOwnProperty('data')) {
	    		$("#"+tableId+" thead tr th:eq("+key+")").addClass('col-export');
	    	}

	        delete tableColumns[key].export;
	    }
	}

	$.fn.dataTable.ext.errMode = 'throw';
	//$.fn.dataTable.ext.errMode = 'none';

	//var dom = "<'row'<'col-12 order-1 mt-2 order-sm-0 mt-sm-0 col-sm-7 col-md-7'l><'col-8 offset-2 order-0 order-sm-1 col-sm-5 offset-sm-0 col-md-5 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 text-center'i>><'row'<'col-sm-12'p>>";

	var dom = "<'row'";
	
	if(showLength && showButtons) {
		dom += "<'col-12 order-1 mt-2 order-sm-0 mt-sm-0 col-sm-7 col-md-7'l>";
		dom += "<'col-8 offset-2 order-0 order-sm-1 col-sm-5 offset-sm-0 col-md-5 text-right'B>";
	}
	else if(showLength && !showButtons) {
		dom += "<'col-12 order-1 mt-2 order-sm-0 mt-sm-0 col-sm-7 col-md-7'l>";
	}
	else if(!showLength && showButtons) {
		dom += "<'col-8 offset-2 offset-md-0 col-md-12 text-right'B>";
	}
	
	dom += ">";

	if(!showLength && !showButtons) {
		dom = "";
	}

	dom += "<'row'<'col-sm-12'tr>>";

	if(showInfo) {
		dom += "<'row mt-2 mb-2'<'col-12 mb-3 col-md-12 col-lg-5 mb-lg-0'i><'col-12 col-md-12 col-lg-7 text-right'p>>";
	}else {
		dom += "<'row mt-2 mb-2'<'col-12 col-md-12 col-lg-12 text-right'p>>";
	}

	if(showLength) {
		var lengthMenu = [[10, 25, 50, 100], [10, 25, 50, 100]];
	}else {
		var lengthMenu = [];
	}

    var table = $('#'+tableId).DataTable({
    	language: {
            url: '/datatable_spanish.json'
        },
        responsive: true,
        processing: false,
        serverSide: false,
        searching: true,
        paging: true,
        columns: tableColumns,
        //order: [[ 0, "desc" ]],
        order: [],
        lengthMenu: lengthMenu,
        info : true,
        //dom: 'lBrtip',
        //dom: "<'row'<'col-sm-6 col-md-6'l><'col-sm-6 col-md-6 text-right'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-7'p>>",
        dom: dom,
        buttons: {
        	dom: {
                button: {
                    className: 'btn'
                }
            },
	        buttons: [
		        {
		        	extend: 'excelHtml5',
		        	text: '<i class="icon-export far fa-fw fa-file-excel"></i> Excel',
		        	title: titleFile,
		        	filename: fileName,
		        	className: 'btn-success btn-export',
				    action: function (e, dt, node, config) {
				    	fnAction('buttons-excel', this, e, dt, node, config);
				    },
				    exportOptions: {
                    	columns: exportColumns
                	},
		        },
		        {
		        	extend: 'pdfHtml5',
		        	text: '<i class="icon-export far fa-fw fa-file-pdf"></i> PDF&nbsp;&nbsp;&nbsp;',
		        	title: titleFile,
		        	filename: fileName,
		        	className: 'btn-danger btn-export',
		        	messageTop: messageTop,
		        	download: openDownload ? 'open' : 'download',
		        	orientation: orientationPdf,
		        	pageSize: pageSize,
		        	action: function (e, dt, node, config) {
				    	fnAction('buttons-pdf', this, e, dt, node, config);
				    },
				    exportOptions: {
                    	columns: exportColumns
                	},
				    customize: function (doc, customize) {
			          if(appendInTitle) {
			            doc.content[0].text += appendInTitle;
			          }
			          
			          //console.log(doc)
			          //console.log(customize)
			          //doc.content[position].table.widths = '40%';

			          var position = 0;
			          var posMsg = 0;
			          for(var i=0; i<doc.content.length; i++) {
			            if('table' in doc.content[i]) {
			              position = i;
			            }
			            if(doc.content[i].style == 'message') {
			              posMsg = i;
			            }
			          }

			          if(sameColumnsWidth) {
			            /*doc.content[position].table.widths = 
			            Array(doc.content[position].table.body[0].length + 1).join('*').split('');*/

			            var tbl = $('#'+tableId);
			            var colCount = new Array();
			            $(tbl).find('thead tr:first-child th[data-export!="false"]').each(function(){
			                if($(this).attr('colspan')){
			                    for(var i=1;i<=$(this).attr('colspan');i++){
			                        colCount.push('*');
			                    }
			                }else{ colCount.push('*'); }
			            });           

			            var w = 100 / colCount.length;
			            w = w.toFixed(2);
			            
			            for(var i=0;i<colCount.length;i++){
			              colCount[i] = w+'%';
			            }
			            //console.log(colCount);

			            doc.content[position].table.widths = colCount;
			          }         

			          var now = new Date();
			          var jsDate = now.getDate()+'-'+((now.getMonth() + 1 < 10 ? '0' : '')+(now.getMonth() + 1))+'-'+now.getFullYear();

			          if(header) {
				          doc['header']=(function() {
				            return {
				              columns: [
				                {
				                  alignment: 'left',
				                  text: [{ text: jsDate.toString() }]
				                }
				              ],
				              margin: 20
				            }
				          });
				      }

			          if(footer) {
				          doc['footer']=(function(page, pages) {
				            return {
				              columns: [
				                {
				                  alignment: 'right',
				                  text: ['Página ', { text: page.toString() },  ' de ', { text: pages.toString() }]
				                }
				              ],
				              margin: 20
				            }
				          });
				      }

			          var rowCount = doc.content[position].table.body.length;
			          var columns = doc.content[position].table.body[0].length;

			          doc.styles.title.color = '#0B62A4';

			          doc.content[0].text = doc.content[0].text.replace(/<br\s*\/?>/ig, "\n");

			          doc.content[posMsg].alignment = 'center';
			          doc.content[posMsg].fontSize = 14;
			          doc.content[posMsg].text = doc.content[posMsg].text.toString().replace(/<br\s*\/?>/ig, "\n");

			          for (i = 0; i < rowCount; i++) {
			            for (j = 0; j < columns; j++) {
			              doc.content[position].table.body[i][j].alignment = 'center';
			              doc.content[position].table.body[i][j].fillColor = 'white';
			              doc.content[position].table.body[i][j].text = doc.content[position].table.body[i][j].text.replace(/<br\s*\/?>/ig, "\n");
			              if(i == 0) {
			                doc.content[position].table.body[i][j].color = '#0B62A4';
			                doc.content[position].table.body[i][j].padding = '20px';
			                doc.content[position].table.body[i][j].text = doc.content[position].table.body[i][j].text.replace(/<br\s*\/?>/ig, "\n");    
			              }             
			            };
			          };

			          var objLayout = {};
			          objLayout['hLineWidth'] = function(i) { return 1; };
			          objLayout['vLineWidth'] = function(i) { return 1; };
			          objLayout['hLineColor'] = function(i) { return '#ECECEC'; };
			          objLayout['vLineColor'] = function(i) { return '#ECECEC'; };
			          objLayout['paddingLeft'] = function(i) { return 5; };
			          objLayout['paddingRight'] = function(i) { return 5; };
			          objLayout['paddingTop'] = function(i) { return 5; };
			          objLayout['paddingBottom'] = function(i) { return 5; };
			          doc.content[position].layout = objLayout;

			        }
		        },
	            //'copyHtml5',
	            //'csvHtml5',
	        ]
    	}
    });

	$('.searchBtn').on('click', function() {
    	$(this).attr("disabled", "disabled");
    	table.search($('.filters .search').val()).draw();
    	$(this).removeAttr("disabled");
    	$('.search').focus();
    })

    $('.search').on('keypress', function (e) {
     	if(e.which === 13){
            $(this).attr("disabled", "disabled");
            table.search($('.filters .search').val()).draw();
            $(this).removeAttr("disabled");
            $(this).focus();
        }
    })

    return table;
}

function dataTableServerSide(tableId, tableColumns, fileName, titleFile, orientationPdf, pageSize, openDownload, sameColumnsWidth, header, footer, showLength, showButtons, showInfo, messageTop='', appendInTitle='', method='GET', dataForm='') {
	if(!tableId) {
		tableId = 'my-table';
	}

	fileName = fileName.toLowerCase();
    fileName = fileName.replace(/\s/g, "-");
    titleFile = titleFile.toUpperCase();

    if(!tableColumns) {
    	tableColumns = [];
    }
    if(tableColumns.length == 0) {
	    $('#'+tableId+' thead tr th').each(function(index, th) {
	        var data_data = $(th).attr('data-data');

	        var data_export = $(th).attr('data-export');
	        data_export = data_export != undefined ? JSON.parse(data_export.replace(/'/g, '"')) : true;

	        var data_orderable = $(th).attr('data-orderable');
	        data_orderable = data_orderable != undefined ? JSON.parse(data_orderable.replace(/'/g, '"')) : true;

	        var data_searchable = $(th).attr('data-searchable');
	        data_searchable = data_searchable != undefined ? JSON.parse(data_searchable.replace(/'/g, '"')) : true;

	        tableColumns.push({
	            data: data_data,
	            export: data_export,
	            orderable: data_orderable,
	            searchable: data_searchable
	        });
	    });
	}

	overwriteExport(tableId, tableColumns, method, dataForm);

    for(var key in tableColumns) {
	    if(tableColumns[key].hasOwnProperty('export')) {
	    	if(tableColumns[key].export === true || tableColumns[key].export.hasOwnProperty('data')) {
	    		$("#"+tableId+" thead tr th:eq("+key+")").addClass('col-export');
	    	}

	        delete tableColumns[key].export;
	    }
	}

	$.fn.dataTable.ext.errMode = 'throw';
	//$.fn.dataTable.ext.errMode = 'none';

	var dom = "<'row'";
	
	if(showLength && showButtons) {
		dom += "<'col-12 order-1 mt-2 order-sm-0 mt-sm-0 col-sm-7 col-md-7'l>";
		dom += "<'col-8 offset-2 order-0 order-sm-1 col-sm-5 offset-sm-0 col-md-5 text-right'B>";
	}
	else if(showLength && !showButtons) {
		dom += "<'col-12 order-1 mt-2 order-sm-0 mt-sm-0 col-sm-7 col-md-7'l>";
	}
	else if(!showLength && showButtons) {
		dom += "<'col-8 offset-2 offset-md-0 col-md-12 text-right'B>";
	}
	
	dom += ">";

	if(!showLength && !showButtons) {
		dom = "";
	}

	dom += "<'row'<'col-sm-12'tr>>";

	if(showInfo) {
		dom += "<'row mt-2 mb-2'<'col-12 mb-3 col-md-12 col-lg-5 mb-lg-0'i><'col-12 col-md-12 col-lg-7 text-right'p>>";
	}else {
		dom += "<'row mt-2 mb-2'<'col-12 col-md-12 col-lg-12 text-right'p>>";
	}

	if(showLength) {
		var lengthMenu = [[10, 25, 50, 100], [10, 25, 50, 100]];
	}else {
		var lengthMenu = [];
	}

    var table = $('#'+tableId).DataTable({
    	language: {
            url: '/datatable_spanish.json'
        },
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        //ajax: url,
        ajax: {
          	url: $('#'+tableId).attr('data-url'),
          	data: function (d) {
            	//d.search['value'] = $('.searchEmail').val()
            	//d.aaa = $('input[name="aaa"]').val();

            	var adittional = {};
				$('.filters [data-filter-export]').each(function(){
					var name = !$(this).attr('data-filter-export') ? $(this).attr('name') : $(this).attr('data-filter-export');
					if(name != 'search') {
						adittional[name] = $(this).val();
					}
				})

            	return $.extend({}, d, adittional);
            },
            complete: function(data) {
            	//$('.dataTables_paginate').parent().parent().find('div').first().removeClass();
            }
        },
        columns: tableColumns,
        "createdRow": function (row, data, rowIndex) {
        	//console.log(data);
	        // Per-cell function to do whatever needed with cells
	        $.each($('td', row), function (colIndex) {

	            // For example, adding data-* attributes to the cell
	            //$(this).attr('data-foo', "bar");
	        });
	    },
        //order: [[ 0, "desc" ]],
        order: [],
        lengthMenu: lengthMenu,
        info : true,
        //dom: 'lBrtip',
        //dom: "<'row'<'col-sm-6 col-md-6'l><'col-sm-6 col-md-6 text-right'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-7'p>>",
        dom: dom,
        buttons: {
        	dom: {
                button: {
                    className: 'btn'
                }
            },
	        buttons: [
		        {
		        	extend: 'excelHtml5',
		        	text: '<i class="icon-export far fa-fw fa-file-excel"></i> Excel',
		        	title: titleFile,
		        	filename: fileName,
		        	className: 'btn-success btn-export',
				    action: function (e, dt, node, config) {
				    	fnAction('buttons-excel', this, e, dt, node, config);
				    }
		        },
		        {
		        	extend: 'pdfHtml5',
		        	text: '<i class="icon-export far fa-fw fa-file-pdf"></i> PDF&nbsp;&nbsp;&nbsp;',
		        	title: titleFile,
		        	filename: fileName,
		        	className: 'btn-danger btn-export',
		        	messageTop: messageTop,
		        	download: openDownload ? 'open' : 'download',
		        	orientation: orientationPdf,
		        	pageSize: pageSize,
		        	action: function (e, dt, node, config) {
				    	fnAction('buttons-pdf', this, e, dt, node, config);
				    },
				    customize: function (doc, customize) {
			          if(appendInTitle) {
			            doc.content[0].text += appendInTitle;
			          }
			          
			          //console.log(doc)
			          //console.log(customize)
			          //doc.content[position].table.widths = '40%';

			          var position = 0;
			          var posMsg = 0;
			          for(var i=0; i<doc.content.length; i++) {
			            if('table' in doc.content[i]) {
			              position = i;
			            }
			            if(doc.content[i].style == 'message') {
			              posMsg = i;
			            }
			          }

			          if(sameColumnsWidth) {
			            /*doc.content[position].table.widths = 
			            Array(doc.content[position].table.body[0].length + 1).join('*').split('');*/

			            var tbl = $('#'+tableId);
			            var colCount = new Array();
			            $(tbl).find('thead tr:first-child th[data-export!="false"]').each(function(){
			                if($(this).attr('colspan')){
			                    for(var i=1;i<=$(this).attr('colspan');i++){
			                        colCount.push('*');
			                    }
			                }else{ colCount.push('*'); }
			            });           

			            var w = 100 / colCount.length;
			            w = w.toFixed(2);
			            
			            for(var i=0;i<colCount.length;i++){
			              colCount[i] = w+'%';
			            }
			            //console.log(colCount);

			            doc.content[position].table.widths = colCount;
			          }         

			          var now = new Date();
			          var jsDate = now.getDate()+'-'+((now.getMonth() + 1 < 10 ? '0' : '')+(now.getMonth() + 1))+'-'+now.getFullYear();

			          if(header) {
				          doc['header']=(function() {
				            return {
				              columns: [
				                {
				                  alignment: 'left',
				                  text: [{ text: jsDate.toString() }]
				                }
				              ],
				              margin: 20
				            }
				          });
				      }

			          if(footer) {
				          doc['footer']=(function(page, pages) {
				            return {
				              columns: [
				                {
				                  alignment: 'right',
				                  text: ['Página ', { text: page.toString() },  ' de ', { text: pages.toString() }]
				                }
				              ],
				              margin: 20
				            }
				          });
				      }

			          var rowCount = doc.content[position].table.body.length;
			          var columns = doc.content[position].table.body[0].length;

			          doc.styles.title.color = '#0B62A4';

			          doc.content[0].text = doc.content[0].text.replace(/<br\s*\/?>/ig, "\n");

			          doc.content[posMsg].alignment = 'center';
			          doc.content[posMsg].fontSize = 14;
			          doc.content[posMsg].text = doc.content[posMsg].text.toString().replace(/<br\s*\/?>/ig, "\n");

			          for (i = 0; i < rowCount; i++) {
			            for (j = 0; j < columns; j++) {
			              doc.content[position].table.body[i][j].alignment = 'center';
			              doc.content[position].table.body[i][j].fillColor = 'white';
			              doc.content[position].table.body[i][j].text = doc.content[position].table.body[i][j].text.replace(/<br\s*\/?>/ig, "\n");
			              if(i == 0) {
			                doc.content[position].table.body[i][j].color = '#0B62A4';
			                doc.content[position].table.body[i][j].padding = '20px';
			                doc.content[position].table.body[i][j].text = doc.content[position].table.body[i][j].text.replace(/<br\s*\/?>/ig, "\n");    
			              }             
			            };
			          };

			          var objLayout = {};
			          objLayout['hLineWidth'] = function(i) { return 1; };
			          objLayout['vLineWidth'] = function(i) { return 1; };
			          objLayout['hLineColor'] = function(i) { return '#ECECEC'; };
			          objLayout['vLineColor'] = function(i) { return '#ECECEC'; };
			          objLayout['paddingLeft'] = function(i) { return 5; };
			          objLayout['paddingRight'] = function(i) { return 5; };
			          objLayout['paddingTop'] = function(i) { return 5; };
			          objLayout['paddingBottom'] = function(i) { return 5; };
			          doc.content[position].layout = objLayout;

			        }
		        },
	            //'copyHtml5',
	            //'csvHtml5',
	        ]
    	}
    });

	$('.searchBtn').on('click', function() {
    	$(this).attr("disabled", "disabled");
    	table.search($('.filters .search').val()).draw();
    	$(this).removeAttr("disabled");
    	$('.search').focus();
    })

    $('.search').on('keypress', function (e) {
     	if(e.which === 13){
            $(this).attr("disabled", "disabled");
            table.search($('.filters .search').val()).draw();
            $(this).removeAttr("disabled");
            $(this).focus();
        }
    })

    return table;
}

function overwriteExport(tableId, tableColumns, method='GET', dataForm='') {
	if(!tableId) {
		tableId = 'my-table';
	}

	var columnsExport = [];

	if(!tableColumns) {
    	tableColumns = [];
    }
	if(tableColumns.length == 0) {
	    $('#'+tableId+' thead tr th').each(function(index, th) {
	        var data_data = $(th).attr('data-data');

	        var data_export = $(th).attr('data-export');
	        data_export = data_export != undefined ? JSON.parse(data_export.replace(/'/g, '"')) : true;

	        var data_orderable = $(th).attr('data-orderable');
	        data_orderable = data_orderable != undefined ? JSON.parse(data_orderable.replace(/'/g, '"')) : true;

	        var data_searchable = $(th).attr('data-searchable');
	        data_searchable = data_searchable != undefined ? JSON.parse(data_searchable.replace(/'/g, '"')) : true;

	        tableColumns.push({
	            data: data_data,
	            export: data_export,
	            orderable: data_orderable,
	            searchable: data_searchable
	        });
	    });
	}

    for(var key in tableColumns) {
	    if(tableColumns[key].hasOwnProperty('export')) {
	    	if(tableColumns[key].export === true) {
	    		columnsExport.push({column: tableColumns[key].data});
	    	}
	    	else if(tableColumns[key].export.hasOwnProperty('data')) {
	    		columnsExport.push({column: tableColumns[key].export.data});
	    	}
	    }
	}

	jQuery.fn.DataTable.Api.register('buttons.exportData()', function (options) {
		var tables = $.fn.dataTable.tables(true);
		var data = $(tables).DataTable().ajax.params();
		data.start = 0;
		data.length = null;

		if(this.context.length) {
		    if(method == 'GET') {
		    	
		    }
		    if(method == 'POST') {
			    /*$.ajaxSetup({
			      headers: {
			          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      }
			    });*/
		    
		    	var data = $('#'+dataForm).serialize()+'&addAction=export';
		  	}

		    var jsonResult = $.ajax({
		        url: $('#'+tableId).attr('data-url'),
		        type: method,
		        data: data,
		        dataType: "json",
		        success: function (result) {
		            //console.log(result)
		        },
		        async: false
		    });

		    jsonResult.responseJSON.data.forEach(function(part, index, theArray) {
		        var newData = [];

		        for(var i=0; i<columnsExport.length; i++) {
		          if($.isArray(columnsExport[i].column)) {
		            if(columnsExport[i].condition) {
		              newData.push(theArray[index][columnsExport[i].column[0]][columnsExport[i].column[1]] == columnsExport[i].condition[0] ? columnsExport[i].condition[1] : columnsExport[i].condition[2]);
		            }else if(columnsExport[i].join) {
		              newData.push(theArray[index][columnsExport[i].column[0]][columnsExport[i].column[1]]+' '+theArray[index][columnsExport[i].join[0]][columnsExport[i].join[1]]);
		            }else{
		              newData.push(theArray[index][columnsExport[i].column[0]][columnsExport[i].column[1]]);
		            }           
		          }else {

		            if(columnsExport[i].equal) {
		              newData.push(theArray[index][columnsExport[i].column] == columnsExport[i].equal[0] ? columnsExport[i].equal[1] : part[columnsExport[i].equal[2]]);
		            }

		            else if(columnsExport[i].addNoDecimal) {
		              newData.push(parseFloat(part[columnsExport[i].addNoDecimal[0]]) + parseFloat(part[columnsExport[i].addNoDecimal[1]]));
		            }

		            else if(columnsExport[i].add) {
		              newData.push((parseFloat(part[columnsExport[i].add[0]]) + parseFloat(part[columnsExport[i].add[1]])).toFixed(2));
		            }

		            else if(columnsExport[i].subtract) {
		              newData.push((parseFloat(part[columnsExport[i].subtract[0]]) - parseFloat(part[columnsExport[i].subtract[1]])).toFixed(2));
		            }

		            else if(columnsExport[i].equalOrMayor) {
		              newData.push(theArray[index][columnsExport[i].column] == columnsExport[i].equalOrMayor[0][0] || theArray[index][columnsExport[i].column] > columnsExport[i].equalOrMayor[0][1] ? columnsExport[i].equalOrMayor[1] : part[columnsExport[i].equalOrMayor[2]]);
		            }

		            else if(columnsExport[i].condition) {
		              newData.push(theArray[index][columnsExport[i].column] == columnsExport[i].condition[0] ? columnsExport[i].condition[1] : columnsExport[i].condition[2]);
		            }else if(columnsExport[i].join) {
		              var separator = ' ';
		              if(columnsExport[i].separator) {
		                separator = columnsExport[i].separator;
		              }
		              var aaaaa = theArray[index][columnsExport[i].column];
		              for(var j=0; j<columnsExport[i].join.length; j++) {
		                if(columnsExport[i].join.length == 1 || j != (columnsExport[i].join.length)) {
		                  
		                  if(theArray[index][columnsExport[i].join[j]]) {
		                    aaaaa+=separator;
		                  }
		                }
		                
		                if(theArray[index][columnsExport[i].join[j]]) {
		                  aaaaa+=theArray[index][columnsExport[i].join[j]];  
		                }
		              }
		              newData.push(aaaaa);
		              //newData.push(theArray[index][columnsExport[i].column]+separator+theArray[index][columnsExport[i].join]);
		            }else {
		              newData.push(theArray[index][columnsExport[i].column]);  
		            } 
		          } 
		        }                
		          delete theArray[index];
		          theArray[index] = newData;
	        });
	      	
	      	return {body: jsonResult.responseJSON.data, header: $("#"+tableId+" thead tr th.col-export").map(function() { return this.innerHTML; }).get()};
		}
	});
}

function fnAction(btn, this2, e, dt, node, config) {
  	var $this = $('.'+btn);

	var iconClass = $this.find('i.icon-export').attr('class');

	var spinner = 'icon-export fas fa-spinner fa-spin';

	$this.find('i.icon-export').removeClass(iconClass).addClass(spinner);
	$this.attr('disabled', true);

		var aa = setInterval(function(){
	    if(!$this.hasClass('processing')) {
	      $this.find('i.icon-export').removeClass(spinner).addClass(iconClass);
	      $this.attr('disabled', false);
	      clearInterval(aa);
	    }       
    }, 1000);

	setTimeout(function() {
		if(btn == 'buttons-excel') {
			$.fn.dataTable.ext.buttons.excelHtml5.action.call(this2, e, dt, node, config);
		}
		if(btn == 'buttons-pdf') {
			$.fn.dataTable.ext.buttons.pdfHtml5.action.call(this2, e, dt, node, config);
		}
		
	}, 500);
}

$.fn.dataTable.Api.register( 'order.neutral()', function () {
    return this.iterator( 'table', function ( s ) {
        s.aaSorting.length = 0;
        s.aiDisplay.sort( function (a,b) {
            return a-b;
        } );
        s.aiDisplayMaster.sort( function (a,b) {
            return a-b;
        } );
    } );
} );

$(document).on('click', '.btn-submit-create, .btn-submit-edit, .btn-submit-status', function(e) {
    e.preventDefault();

    var $this = $(this);
    $this.attr('disabled', true);

    var form = $this.parents('form');

    var url = form.attr('action');
    var data = form.serialize();
    var modal = ($this.parents('.modal'));
    var text_button = $this.html();
    removeValidationErrorMessage();

    $this.html('Enviando <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

    modal.find('button.close').attr('disabled', true);

    $.ajax({
   		type: form.attr('method'),
        url: url,
        data: data,
        success: function(data) {
      		if(data.success) {
	          	var table = $.fn.dataTable.tables(true);
	          	//$(table).DataTable().ajax.reload();
	          	//var order = $(table).DataTable().order();
	          	//console.log($(table).DataTable().order.neutral())
	          	$(table).DataTable().order([]).ajax.reload();
      		}

      		modal.modal('hide');
      		form.trigger('reset');
      		$this.attr('disabled', false);
      		$this.html(text_button);
      		modal.find('button.close').attr('disabled', false);
      		showAlert(data.success, data.message);
        },
        error: function(response){
        	$this.html(text_button);
        	modal.find('button.close').attr('disabled', false);

        	if(response.status == 419) {
        		modal.modal('hide');
      			form.trigger('reset');

        		showAlert(0, 'Recarga la página o vuelva a iniciar sesión');
        	}else {
        		validationErrorMessage(form, response.responseJSON.errors);	
        	}
      		
            $this.attr('disabled', false);
        }
    });
});

$(document).on('click', '#edit', function(e) {
	e.preventDefault();

	var url_show = $(this).attr('data-url-show');
	var url_update = $(this).attr('data-url-update');

	$.ajax({
   		type: 'GET',
        url: url_show,
        data: {},
        success: function(data) {
      		if(data) {
      			$('#modalEdit').find('form').find(":input").each(function(v) {
      				var type = $(this).attr('type');
      				var name = $(this).attr('name');
      				var id = $(this).attr('id');
      				var name_default = $(this).attr('name');
      				var isArray = false;
      				
      				if(name && name.indexOf('[]') >= 0) {
      					isArray = true;
      					name = name.slice(0,-2);
      				}

      				var tag_name = $(this).prop("tagName").toLowerCase();
      				//console.log(tag_name+'[name="'+name_default+'"]');

      				$('#modalCreate').find(tag_name+'[name="'+name_default+'"][id="'+id+'"]').attr('data-id', id);
					$('#modalCreate').find(tag_name+'[name="'+name_default+'"][id="'+id+'"]').attr('id', '_');

      				if(tag_name == 'input') {
      					switch(type) {
							case 'text':
								$(this).val(data[name]);
							break;
							case 'radio':
								if($(this).val() == data[name]) {
									$(this).attr('checked', true);
								}else {
									$(this).attr('checked', false);
								}
							case 'checkbox':
								if(isArray) {
									for(var j = 0; j < data[name].length; j++) {
										if($(this).val() == data[name][j].id) {
											$(this).attr('checked', true);
										}
									}
								}else {
									if($(this).val() == data[name]) {
										$(this).attr('checked', true);
									}
								}
							break;
							default:
								$(this).val(data[name]);
							break;
						}
      				}else if(tag_name == 'select') {
      					$(this).val(data[name]);
      				}
      			});
	          	$('#modalEdit').modal('show');
	          	$('#modalEdit').find('form').attr('action', url_update);
      		}
        }
    });
});

$(document).on('click', '#activeOrDesactivate', function(e) {
	e.preventDefault();

	var url_destroy = $(this).attr('data-url-destroy');
	var status = $(this).attr('data-status');
	var text_status = $(this).text();

	$('#modalActiveOrDesactivate').find('.text-status').text(text_status);
	$('#modalActiveOrDesactivate').find('input[name="status"]').val(status);
	$('#modalActiveOrDesactivate').modal('show');
  	$('#modalActiveOrDesactivate').find('form').attr('action', url_destroy);
  	$('#modalActiveOrDesactivate').find('.btn-submit-status').text(text_status);
});

$(".modal-form").on("hidden.bs.modal", function () {
    removeValidationErrorMessage();
    $(this).find('form').trigger('reset');
    $(this).find('form').find('input:checkbox').removeAttr('checked');

    if($(this).attr('id') == 'modalEdit') {
    	$('#modalCreate').find('[id="_"]').each(function() {
    		$(this).attr('id', $(this).attr('data-id'));
    		$(this).removeAttr('data-id');
    	});
    }
});

function showAlert(status, message, animateTop = true) {
	var iconMessage = '<i class="fas fa-times icon-c"></i>';
  	var alertClass = 'alert-danger';
  	
  	if(status) {
  		iconMessage = '<i class="fas fa-check icon-c"></i>';
  		alertClass = 'alert-success';
  	}

  	$('#alert-message .alert').removeClass('alert-danger').removeClass('alert-success');
  	$('#alert-message .alert').addClass(alertClass);
  	$('#alert-message .alert').html(iconMessage + ' ' + message);
  	$('#alert-message').removeClass('d-none');

  	if(animateTop) {
  		$('html').animate({ scrollTop: 0 }, 350, function () {
	    });
  	}
}

function validationErrorMessage(form, errors) {
	removeValidationErrorMessage();

	$.each(errors, function(field_name, error) {
		form.find('[name="'+field_name+'"]').after('<span class="validation-error-message font-weight-bold text-danger">'+error+'</span>');

		form.find('[name="'+field_name+'[]"]').parents('.form-group').append('<span class="validation-error-message font-weight-bold text-danger">'+error+'</span>');
    })

	/*$.each(errors, function(field_name, error) {
		if(form.find('[name='+field_name+']').next().hasClass('validation-error-message')) {
			form.find('[name='+field_name+']').next().remove();
		}

		form.find('[name='+field_name+']').after('<span class="validation-error-message font-weight-bold text-danger">'+error+'</span>');
    })*/
}

function removeValidationErrorMessage(form, errors) {
	$('.validation-error-message').remove();
}