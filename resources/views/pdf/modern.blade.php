<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #0f172a; background: #ffffff; }
.page { padding: 44px 56px; }
.name { font-size: 28px; font-weight: bold; color: #0f172a; line-height: 1.1; letter-spacing: -0.4px; margin-bottom: 3px; }
.accent-line { border: none; border-top: 3px solid #64748b; width: 48px; margin: 0; padding: 0; font-size: 0; height: 0; margin-bottom: 16px; }
.contact { font-size: 9.5px; color: #64748b; line-height: 1.6; }
.section-header { font-size: 8px; font-weight: bold; text-transform: uppercase; letter-spacing: 2.5px; color: #64748b; margin-top: 24px; margin-bottom: 10px; }
.section-block { border-left: 2.5px solid #e2e8f0; padding-left: 14px; }
.summary { font-size: 10px; line-height: 1.7; color: #475569; }
.exp-entry { margin-bottom: 16px; }
.exp-title { font-size: 11.5px; font-weight: bold; color: #0f172a; line-height: 1.3; }
.exp-meta { font-size: 9.5px; color: #64748b; font-style: italic; margin-top: 2px; }
.exp-dates { font-size: 9px; color: #94a3b8; white-space: nowrap; }
.exp-desc { font-size: 10px; line-height: 1.7; color: #475569; margin-top: 5px; }
.edu-entry { margin-bottom: 12px; }
.edu-title { font-size: 11px; font-weight: bold; color: #0f172a; }
.edu-meta { font-size: 9.5px; color: #64748b; margin-top: 1px; }
.skill-item { font-size: 10px; color: #475569; line-height: 1.9; }
.cover-page { padding: 44px 56px; page-break-before: always; }
.cover-name { font-size: 22px; font-weight: bold; color: #0f172a; line-height: 1.15; letter-spacing: -0.3px; }
.cover-accent { border: none; border-top: 3px solid #64748b; width: 48px; margin: 8px 0 12px; padding: 0; font-size: 0; height: 0; }
.cover-contact { font-size: 9.5px; color: #64748b; }
.cover-date { font-size: 9.5px; color: #94a3b8; margin-top: 30px; margin-bottom: 22px; }
.cover-greeting { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
.cover-sign { font-size: 10.5px; color: #374151; margin-top: 22px; }
</style>
</head>
<body>
<div class="page">
<div class="name">{{ $resume['full_name'] ?? $application->resume->full_name ?? '' }}</div>
<hr class="accent-line">
<div class="contact">{{ $resume['email'] ?? $application->resume->email }} &nbsp;&middot;&nbsp; {{ $resume['phone'] ?? $application->resume->phone }} &nbsp;&middot;&nbsp; {{ $resume['location'] ?? $application->resume->location }}</div>

@if($resume['summary'] ?? null)
<div class="section-header">Summary</div>
<div class="section-block">
<div class="summary">{{ $resume['summary'] }}</div>
</div>
@endif

@if(!empty($resume['work_experience']))
<div class="section-header">Experience</div>
<div class="section-block">
@foreach($resume['work_experience'] as $job)
<div class="exp-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top">
<div class="exp-title">{{ $job['title'] ?? '' }}</div>
<div class="exp-meta">{{ $job['company'] ?? '' }}</div>
</td>
<td valign="top" align="right" class="exp-dates">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' &ndash; ' . $job['end_date'] : ' &ndash; Present' }}</td>
</tr></table>
@if(!empty($job['description']))
<div class="exp-desc">{{ $job['description'] }}</div>
@endif
</div>
@endforeach
</div>
@endif

@if(!empty($resume['skills']))
@php
    $skillsClean = array_values(array_filter($resume['skills']));
    $half = (int) ceil(count($skillsClean) / 2);
    $skillsLeft  = array_slice($skillsClean, 0, $half);
    $skillsRight = array_slice($skillsClean, $half);
@endphp
<div class="section-header">Skills</div>
<div class="section-block">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="50%" valign="top" style="padding-right: 12px;">
@foreach($skillsLeft as $skill)
<div class="skill-item">&middot; {{ $skill }}</div>
@endforeach
</td>
<td width="50%" valign="top" style="padding-left: 12px;">
@foreach($skillsRight as $skill)
<div class="skill-item">&middot; {{ $skill }}</div>
@endforeach
</td>
</tr>
</table>
</div>
@endif

@if(!empty($resume['education']))
<div class="section-header">Education</div>
<div class="section-block">
@foreach($resume['education'] as $edu)
<div class="edu-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top">
<div class="edu-title">{{ $edu['degree'] ?? '' }}</div>
<div class="edu-meta">{{ $edu['institution'] ?? '' }}</div>
</td>
<td valign="top" align="right" class="exp-dates">{{ $edu['year'] ?? '' }}</td>
</tr></table>
</div>
@endforeach
</div>
@endif
</div>

@if($coverLetter)
<div class="cover-page">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<hr class="cover-accent">
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} &nbsp;&middot;&nbsp; {{ $resume['phone'] ?? $application->resume->phone }} &nbsp;&middot;&nbsp; {{ $resume['location'] ?? $application->resume->location }}</div>
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
<div class="cover-greeting">Dear {{ $application->company_name }} Hiring Team,</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach
<div class="cover-sign">Sincerely,<br><br><strong>{{ $resume['full_name'] ?? $application->resume->full_name }}</strong></div>
</div>
@endif
</body>
</html>
