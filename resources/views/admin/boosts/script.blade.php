<script type="text/javascript">
    $(document).ready(function () {
        $('#frmRequestBoost').submit(function (e) { 
            e.preventDefault();
            $('#requester-error').text('');
            $('#company-error').text('');
            $('#group-error').text('');
            $('#url-error').text('');
            $('#budget-error').text('');
            $('#pnp-error').text('');
            $('#start_date-error').text('');
            $('#channel_id-error').text('');

            let requester = $('#requester').val();
            let company = $('#company').val();
            let group = $('#group').val();
            let url = $('#url').val();
            let budget = $('#budget').val();
            let pnp = $('#pnp').val();
            let start_date = $('#start_date').val();
            let detail = $('#detail').val();
            let _token = $("input[name=_token]").val();
            var channel = [];

            $("input:checkbox[name=channel]:checked").each(function(){
                channel.push($(this).val());
            });
            $.ajax({
                url: "{{route('boost.store')}}",
                type: "POST",
                data: {
                    requester: requester,
                    company: company,
                    group: group,
                    url: url,
                    budget: budget,
                    pnp: pnp,
                    start_date: start_date,
                    channel: channel,
                    detail: detail,
                    _token: _token,
                },
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $("#frmRequestBoost")[0].reset();
                        Swal.fire(
                            'សូមអគុណ!',
                            'សំណើររបស់អ្នកបានផ្ញើរដោយជោគជ័យ',
                            'success'
                        )
                    }
                },
                error: function (response) {
                    $('#requester-error').text(response.responseJSON.errors.requester);
                    $('#company-error').text(response.responseJSON.errors.company);
                    $('#group-error').text(response.responseJSON.errors.group);
                    $('#url-error').text(response.responseJSON.errors.url);
                    $('#budget-error').text(response.responseJSON.errors.budget);
                    $('#pnp-error').text(response.responseJSON.errors.pnp);
                    $('#start_date-error').text(response.responseJSON.errors.start_date);
                }
            });

            
        });
    });
    
</script>