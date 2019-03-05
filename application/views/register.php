<form action="<?=base_url();?>/register/finish" method="POST">
    <table border="0">
        <tr>
            <th>Registration</th>
        </tr>
        <tr>
            <td>
                Username:
            </td>
            <td>
                <input type="text" name="username">
            </td>
        </tr>
        <tr>
            <td>
                E-Mail:
            </td>
            <td>
                <input type="text" name="email">
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit">
            </td>
        </tr>
    </table>
</form>
