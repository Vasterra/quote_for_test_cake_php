<div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
    <h1>Report</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Number of visitiors</th>
            <th scope="col">Number of clicks</th>
            <th scope="col">CTR, %</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">A</th>
            <td><?=$report_data->num_visitors_for_a?></td>
            <td><?=$report_data->num_clicks_for_a?></td>
            <td><?=round($report_data->num_clicks_for_a/$report_data->num_visitors_for_a*100, 2)?></td>
        </tr>
        <tr>
            <th scope="row">B</th>
            <td><?=$report_data->num_visitors_for_b?></td>
            <td><?=$report_data->num_clicks_for_b?></td>
            <td><?=round($report_data->num_clicks_for_b/$report_data->num_visitors_for_b*100, 2)?></td>
        </tr>
        </tbody>
    </table>
</div>
