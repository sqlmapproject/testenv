<%@ Page Language="C#"%>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Web" %>
<%@ Import Namespace="Npgsql" %>

<script language="C#" runat="server">
        public DataTable GetData()
        {
            string idpar = Request.QueryString["id"].ToString();
            string strsql = "SELECT * FROM users WHERE id=" + idpar;

            Npgsql.NpgsqlConnection oConn = new Npgsql.NpgsqlConnection("Server=127.0.0.1;Port=5433;Userid=postgres;Password=testpass;Database=testdb");
            oConn.Open();

            DataSet oDataSet = new System.Data.DataSet("tab1");
            Npgsql.NpgsqlDataAdapter oAdapter = new Npgsql.NpgsqlDataAdapter(strsql, oConn); 
            oAdapter.Fill(oDataSet, "tab1"); 
            DataTable dt = oDataSet.Tables["tab1"]; 
            oConn.Close();

            return dt;


        }
        protected void Page_Load(object sender, EventArgs e)
        {
            GridView1.DataSource = GetData();
            GridView1.DataBind();
        }
</script>

<html>
<head>
<title>Simple PostgreSQL Database Query</title>
</head>
<body>

<form runat="server">

<asp:DataGrid id="GridView1" runat="server" />

</form>

</body>
</html> 
