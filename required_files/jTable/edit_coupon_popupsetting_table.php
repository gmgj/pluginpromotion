<html>
<head>
<meta charset="utf-8">
<link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />

<script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
<title>edit popupsetting table</title>
</head>
<body>
<div style='text-align:center'>
<h1>Edit popusetting table</h2>
<p>Please do not delete any of the first 9 keys, they are required</p>
</div>
<div id="PopUpTableContainer" style="width: 800px;margin:0 auto;"></div>
<script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#PopUpTableContainer').jtable({
				title: 'PopUpSettings',
				actions: {
					listAction:  'PopUpSettingsActions.php?action=list',
					createAction: 'PopUpSettingsActions.php?action=create',
					updateAction: 'PopUpSettingsActions.php?action=update',
					deleteAction: 'PopUpSettingsActions.php?action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					type: {
						title: 'Key',
						width: '200px',
                		create: true,
                		edit: true,
                		list: true,
                		input: function (data) {
					        if (data.record) {
					           	return '<input type="text" readonly name="type" style="width:200px; background-color: lightgray;" id="type" value="' + data.record.type + '"  />';
					        } else {
					            return '<input type="text" name="type" style="width:200px" value="key" />';
					        }
						}
					},
					value: {
						title: 'Value',
						width: '600px'
					}
				}
			});

			//Load person list from server
			$('#PopUpTableContainer').jtable('load');

		});

</script>
</body>
</html>
