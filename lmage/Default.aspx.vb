
Partial Class _Default
    Inherits System.Web.UI.Page

   

    Protected Sub DropDownList1_SelectedIndexChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles DropDownList1.SelectedIndexChanged
        If DropDownList1.Text = "0" Then
            Image1.ImageUrl = "~//8.jpg"
        ElseIf DropDownList1.Text = "1" Then
            Image1.ImageUrl = "~//CBR.JPG"
        Else
            Image1.ImageUrl = "~//2.jpg"
        End If
    End Sub
End Class
