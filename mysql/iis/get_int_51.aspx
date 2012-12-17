<%@ Page Language="VB" debug="true" %>
<%@ Import Namespace = "System.Data" %>
<%@ Import Namespace = "MySql.Data.MySqlClient" %>
<script language="VB" runat="server">

Sub Page_Load(sender As Object, e As EventArgs)

    Dim myConnection  As MySqlConnection
    Dim myDataAdapter As MySqlDataAdapter
    Dim myDataSet     As DataSet

    Dim strSQL        As String
    Dim iRecordCount  As Integer

    myConnection = New MySqlConnection("server=localhost; port=3307; user id=root; password=testpass; database=testdb; pooling=false;")

    strSQL = "SELECT * FROM users WHERE id=" + Request.querystring("id") + ";"

    myDataAdapter = New MySqlDataAdapter(strSQL, myConnection)
    myDataSet = New Dataset()
    myDataAdapter.Fill(myDataSet, "mytable")

    MySQLDataGrid.DataSource = myDataSet
    MySQLDataGrid.DataBind()

End Sub

</script>

<html>
<head>
<title>Simple MySQL Database Query</title>
</head>
<body>

<form runat="server">

<asp:DataGrid id="MySQLDataGrid" runat="server" />

</form>

</body>
</html> 
