<!DOCTYPE html>
<html style="background: #ffffff">
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body { height: 100%; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; font-size: 10.5px; color: #1a1a1a; background: #ffffff; }

.page { padding: 48px 52px; }

.name { font-size: 24px; font-weight: bold; text-align: center; letter-spacing: 1px; color: #000000; margin-bottom: 6px; }
.contact { text-align: center; font-size: 9.5px; color: #555555; margin-bottom: 6px; }
.divider { border: none; border-top: 1.5px solid #000000; margin-top: 12px; margin-bottom: 18px; }

.section-header { font-size: 9px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; color: #000000; border-bottom: 1px solid #000000; padding-bottom: 3px; margin-top: 20px; margin-bottom: 10px; }

.summary { font-size: 10px; line-height: 1.7; color: #333333; margin-bottom: 4px; }

.exp-entry { margin-bottom: 16px; }
.exp-title { font-size: 11px; font-weight: bold; color: #000000; }
.exp-dates { font-size: 9px; color: #777777; white-space: nowrap; }
.exp-company { font-size: 9.5px; color: #555555; font-style: italic; margin-bottom: 5px; }
.exp-desc { font-size: 10px; line-height: 1.65; color: #333333; }

.edu-entry { margin-bottom: 12px; }
.edu-degree { font-size: 11px; font-weight: bold; color: #000000; }
.edu-meta { font-size: 9.5px; color: #555555; font-style: italic; }

.skills-paragraph { font-size: 10px; color: #333333; line-height: 1.8; text-align: center; }

.cover-page { padding: 48px 52px; page-break-before: always; background-color: #ffffff; }
.cover-name { font-size: 20px; font-weight: bold; color: #000000; margin-bottom: 4px; }
.cover-contact { font-size: 9.5px; color: #555555; margin-bottom: 4px; }
.cover-hr { border: none; border-top: 1px solid #aaaaaa; margin: 14px 0 20px; }
.cover-date { font-size: 10px; color: #555555; margin-bottom: 16px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #333333; margin-bottom: 14px; }
.cover-sign { font-size: 10.5px; line-height: 1.7; color: #333333; margin-top: 28px; }
</style>
</head>
<body style="background: #ffffff;">

<div class="page">

<div class="name">{{ strtoupper($resume['full_name'] ?? $application->resume->full_name ?? '') }}</div>
<div class="contact">{{ $resume['email'] ?? $application->resume->email }} · {{ $resume['phone'] ?? $application->resume->phone }} · {{ $resume['location'] ?? $application->resume->location }}</div>
<hr class="divider">

@if($resume['summary'] ?? null)
<div class="section-header">Summary</div>
<div class="summary">{{ $resume['summary'] }}</div>
@endif

@if(!empty($resume['work_experience']))
<div class="section-header">Experience</div>
@foreach($resume['work_experience'] as $job)
<div class="exp-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top"><span class="exp-title">{{ $job['title'] ?? '' }}</span></td>
<td valign="top" align="right"><span class="exp-dates">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – ' . $job['end_date'] : ' – Present' }}</span></td>
</tr></table>
<div class="exp-company">{{ $job['company'] ?? '' }}</div>
@if(!empty($job['description']))
<div class="exp-desc">{{ $job['description'] }}</div>
@endif
</div>
@endforeach
@endif

@if(!empty($resume['education']))
<div class="section-header">Education</div>
@foreach($resume['education'] as $edu)
<div class="edu-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top"><span class="edu-degree">{{ $edu['degree'] ?? '' }}</span></td>
<td valign="top" align="right"><span class="exp-dates">{{ $edu['year'] ?? '' }}</span></td>
</tr></table>
<div class="edu-meta">{{ $edu['institution'] ?? '' }}</div>
</div>
@endforeach
@endif

@if(!empty($resume['skills']))
<div class="section-header">Skills</div>
<div class="skills-paragraph">{{ implode(' · ', array_filter($resume['skills'])) }}</div>
@endif

</div>

@if($coverLetter)
<div class="cover-page">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} · {{ $resume['phone'] ?? $application->resume->phone }}</div>
<hr class="cover-hr">
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach

<div class="cover-sign">
Sincerely,
<br><br>
{{ $resume['full_name'] ?? $application->resume->full_name }}<br>
{{ $resume['email'] ?? $application->resume->email }}
</div>
</div>
@endif

</body>
</html>
