<h2>Only the 20 most recent scores are displayed.</h2>
<table width="100%">
<tr>
    <th>Date Entered</th>
    <th>Course Name</th>
    <th>Course Rating</th>
    <th>Slope</th>
    <th>Score</th>
    <th>Options</th>
</tr>
<!-- BEGIN empty_table -->
<tr>
    <td colspan=20>{EMPTY_MESSAGE}</td>
</tr>
<!-- END empty_table -->
<!-- BEGIN listrows -->
<tr{TOGGLE}>
    <td>{TIMESTAMP}</td>
    <td>{COURSE_NAME}</td>
    <td>{COURSE_RATING}</td>
    <td>{SLOPE}</td>
    <td>{SCORE}</td>
    <td>{DELETE}</td>
</tr>
<!-- END listrows -->
</table>
