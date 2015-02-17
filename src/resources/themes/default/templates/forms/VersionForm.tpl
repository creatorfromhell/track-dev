<script>
    new datepickr('due-date', {
        fullCurrentMonth: true,
        dateFormat: 'Y-m-d',
        weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        suffix: { 1: 'st', 2: 'nd', 3: 'rd' },
        defaultSuffix: 'th'
    });
</script>