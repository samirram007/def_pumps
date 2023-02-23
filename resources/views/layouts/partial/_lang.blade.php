<script>
     var lang='{{app()->getLocale() }}';
        //console.log(lang=='in');
        var langOpt={
             "sSearch": "Search:",
                  "sLengthMenu": "Show _MENU_ entries",
                  "sInfo": "Showing _START_ to _END_ of _TOTAL_",
                  "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                  "sInfoFiltered": "(filtered from _MAX_ total entries)",
                  "sZeroRecords": "No records found",
        };


            // console.log(langOpt);
        if(lang =='in' ){
            langOpt=
            {
                  "sProcessing": "प्रगति पे हैं ...",
                  "sLengthMenu": "दिखाएं  _MENU_ प्रविष्टियां ",
                  "sZeroRecords": "रिकॉर्ड्स का मेल नहीं मिला",
                  "sInfo": "_START_ to _END_ of _TOTAL_ प्रविष्टियां दिखा रहे हैं",
                  "sInfoEmpty": "0 में से 0 से 0 प्रविष्टियां दिखा रहे हैं",
                  "sInfoFiltered": "(_MAX_ कुल प्रविष्टियों में से छठा हुआ)",
                  "sInfoPostFix": "",
                  "sSearch": "खोजें:",
                  "sUrl": "",
                  "oPaginate": {
                      "sFirst": "प्रथम",
                      "sPrevious": "पिछला",
                      "sNext": "अगला",
                      "sLast": "अंतिम"
                  }
              };
        }
        if(lang =='bn' ){
            langOpt=
            {
                  "sProcessing": "প্রগতি পর্যন্ত হচ্ছে ...",
                  "sLengthMenu": "দেখান _MENU_ প্রবেশকর্তার",
                  "sZeroRecords": "রেকর্ড মিল না",
                  "sInfo": "_START_ to _END_ of _TOTAL_ প্রবেশকর্তার দেখান",
                  "sInfoEmpty": "0 থেকে 0 থেকে 0 প্রবেশকর্তার দেখান",
                  "sInfoFiltered": "(_MAX_ মোট প্রবেশকর্তার থেকে ছাঁটা হয়েছে)",
                  "sInfoPostFix": "",
                  "sSearch": "অনুসন্ধান :",
                  "sUrl": "",
                  "oPaginate": {
                      "sFirst": "প্রথম",
                      "sPrevious": "পূর্ববর্তী",
                      "sNext": "পরবর্তী",
                      "sLast": "শেষ"
                  }
              };
        }
</script>
