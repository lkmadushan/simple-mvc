<script>
    function isValidJson() {
        var str = document.forms['json']['bill'].value;
        try {
            JSON.parse(str);
        } catch (e) {
            alert('Invalid json string');

            return false;
        }
        return true;
    }
</script>
</body>
</html>