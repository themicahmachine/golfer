<h1>{TITLE}</h1><br/>
{ADD_GOLFER_LINK} | {UPDATE_HC_LINK}
<br/>
<div style="color:green; font-weight:bold;">{ERROR}</div>
<br/>
<h2>Current Handicaps</h2>
<table width="350px">
<tr>
    <th>Golfer</th>
    <th>Handicap</th>
    <th>Options</th>
</tr>
<!-- BEGIN empty_table -->
<tr>
    <td colspan=20>{EMPTY_MESSAGE}</td>
</tr>
<!-- END empty_table -->
<!-- BEGIN listrows -->
<tr {TOGGLE}>
    <td>{NAME}</td>
    <td>{CURRENT_HANDICAP}</td>
    <td>{SCORE_LINK} | {DELETE}</td>
</tr>
<!-- END listrows -->
<tr>
    <td colspan=20>
        <div align="center">
        <br/><br/>
        {TOTAL_ROWS} Golfers<br/>
        <b>{PAGE_TITLE}</b><br/>
        {PAGES}<br/>
        {LIMITS}<br/>
        {CSV_REPORT}
        </div>
    </td>
</tr>
</table>
