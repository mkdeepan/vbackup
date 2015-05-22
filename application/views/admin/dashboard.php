<script src="<?php echo base_url();?>source/vendor/Chart.js/Chart.min.js"></script>
<div class="container-fluid container-fullw padding-bottom-10">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-md-7 col-lg-8">
											<div class="panel panel-white no-radius" id="visits">
												<div class="panel-heading border-light">
													<h4 class="panel-title"> Visits </h4>
													<ul class="panel-heading-tabs border-light">
														<li>
															<div class="pull-right">
																<div class="btn-group">
																	<a class="padding-10" data-toggle="dropdown">
																		<i class="ti-more-alt "></i>
																	</a>
																	<ul class="dropdown-menu dropdown-light" role="menu">
																		<li>
																			<a href="#">
																				Action
																			</a>
																		</li>
																		<li>
																			<a href="#">
																				Another action
																			</a>
																		</li>
																		<li>
																			<a href="#">
																				Something else here
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</li>
														<li>
															<div class="rate">
																<i class="fa fa-caret-up text-primary"></i><span class="value">15</span><span class="percentage">%</span>
															</div>
														</li>
														<li class="panel-tools">
															<a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
														</li>
													</ul>
												</div>
												<div collapse="visits" class="panel-wrapper">
													<div class="panel-body">
														<div class="height-350">
															<canvas id="chart1" class="full-width"></canvas>
															<div class="margin-top-20">
																<div class="inline pull-left">
																	<div id="chart1Legend" class="chart-legend"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-5 col-lg-4">
											<div class="panel panel-white no-radius">
												<div class="panel-heading border-light">
													<h4 class="panel-title"> Acquisition </h4>
												</div>
												<div class="panel-body">
													<h3 class="inline-block no-margin">26</h3> visitors on-line
													<div class="progress progress-xs no-radius">
														<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
															<span class="sr-only"> 40% Complete</span>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4">
															<h4 class="no-margin">15</h4>
															<div class="progress progress-xs no-radius no-margin">
																<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
																	<span class="sr-only"> 80% Complete</span>
																</div>
															</div>
															Direct
														</div>
														<div class="col-sm-4">
															<h4 class="no-margin">7</h4>
															<div class="progress progress-xs no-radius no-margin">
																<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
																	<span class="sr-only"> 60% Complete</span>
																</div>
															</div>
															Sites
														</div>
														<div class="col-sm-4">
															<h4 class="no-margin">4</h4>
															<div class="progress progress-xs no-radius no-margin">
																<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
																	<span class="sr-only"> 40% Complete</span>
																</div>
															</div>
															Search
														</div>
													</div>
													<div class="row margin-top-30">
														<div class="col-xs-4 text-center">
															<div class="rate">
																<i class="fa fa-caret-up text-green"></i><span class="value">26</span><span class="percentage">%</span>
															</div>
															Mac OS X
														</div>
														<div class="col-xs-4 text-center">
															<div class="rate">
																<i class="fa fa-caret-up text-green"></i><span class="value">62</span><span class="percentage">%</span>
															</div>
															Windows
														</div>
														<div class="col-xs-4 text-center">
															<div class="rate">
																<i class="fa fa-caret-down text-red"></i><span class="value">12</span><span class="percentage">%</span>
															</div>
															Other OS
														</div>
													</div>
													<div class="margin-top-10">
														<div class="height-180">
															<canvas id="chart2" class="full-width"></canvas>
															<div class="inline pull-left legend-xs">
																<div id="chart2Legend" class="chart-legend"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

<script>
			jQuery(document).ready(function() {
				Main.init();
				var options = {
			// Sets the chart to be responsive
			responsive: true,

			///Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines: true,

			//String - Colour of the grid lines
			scaleGridLineColor: 'rgba(0,0,0,.05)',

			//Number - Width of the grid lines
			scaleGridLineWidth: 1,

			//Boolean - Whether the line is curved between points
			bezierCurve: true,

			//Number - Tension of the bezier curve between points
			bezierCurveTension: 0.4,

			//Boolean - Whether to show a dot for each point
			pointDot: true,

			//Number - Radius of each point dot in pixels
			pointDotRadius: 4,

			//Number - Pixel width of point dot stroke
			pointDotStrokeWidth: 1,

			//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
			pointHitDetectionRadius: 20,

			//Boolean - Whether to show a stroke for datasets
			datasetStroke: true,

			//Number - Pixel width of dataset stroke
			datasetStrokeWidth: 2,

			//Boolean - Whether to fill the dataset with a colour
			datasetFill: true,

			// Function - on animation progress
			onAnimationProgress: function() {
			},

			// Function - on animation complete
			onAnimationComplete: function() {
			},

			//String - A legend template
			legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
		};
		var data = {
			labels: ["1", "2", "3", "4", "5", "6", "7"],
			datasets: [{
				label: "Android",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [1,2,3,4,5,6,7]
			}, {
				label: "IOS",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [7,6,5,4,3,2,1]
			},	{
				label: "Website",
				fillColor: "rgba(131,157,285,0.2)",
				strokeColor: "rgba(131,157,285,1)",
				pointColor: "rgba(131,157,285,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [9,6,1,4,0,2,1]
			}]
		};
      //datasets[1].addData([40, 60], "7");
		// Get context with jQuery - using jQuery's .get() method.
		var ctx = $("#chart1").get(0).getContext("2d");
		// This will get the first returned node in the jQuery collection.
		var lineChart = new Chart(ctx).Line(data, options);
		//generate the legend
		var legend = lineChart.generateLegend();
		//and append it to your page somewhere
		$('#chart1Legend').append(legend);
		
		//Charts.init();
			});
		</script>