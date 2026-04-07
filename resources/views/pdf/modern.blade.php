<!DOCTYPE html>
<html style="background: #ffffff">
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body { height: 100%; margin: 0; padding: 0; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #0f172a; background: #ffffff; }

.page { padding: 44px 56px; }

.name { font-size: 26px; font-weight: bold; color: #0f172a; line-height: 1.1; letter-spacing: -0.4px; margin-bottom: 4px; }
.accent-block { width: 40px; height: 3px; background-color: #6366f1; font-size: 0; line-height: 0; margin-bottom: 14px; }
.contact { font-size: 9px; color: #64748b; line-height: 1.6; margin-bottom: 20px; }

.section-header { font-size: 8.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #0f172a; margin-top: 24px; margin-bottom: 4px; }
.section-rule { border-top: 1px solid #e2e8f0; height: 0; font-size: 0; line-height: 0; margin-bottom: 12px; }

.summary { font-size: 10px; line-height: 1.7; color: #475569; }

.exp-entry { margin-bottom: 18px; }
.exp-title { font-size: 11.5px; font-weight: bold; color: #0f172a; line-height: 1.3; margin-bottom: 2px; }
.exp-company { font-size: 9.5px; color: #64748b; }
.exp-dates { font-size: 9px; color: #94a3b8; white-space: nowrap; }
.exp-desc { font-size: 10px; line-height: 1.7; color: #475569; margin-top: 5px; }

.edu-entry { margin-bottom: 12px; }
.edu-title { font-size: 11px; font-weight: bold; color: #0f172a; }
.edu-meta { font-size: 9.5px; color: #64748b; margin-top: 1px; }

.skill-item { font-size: 9.5px; color: #475569; line-height: 1.9; }

.cover-page { padding: 44px 56px; page-break-before: always; background-color: #ffffff; }
.cover-name { font-size: 22px; font-weight: bold; color: #0f172a; line-height: 1.15; letter-spacing: -0.3px; }
.cover-accent { width: 40px; height: 3px; background-color: #6366f1; font-size: 0; line-height: 0; margin: 8px 0 14px; }
.cover-contact { font-size: 9.5px; color: #64748b; }
.cover-date { font-size: 9.5px; color: #94a3b8; margin-top: 30px; margin-bottom: 22px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
</style>
</head>
<body style="background: #ffffff;">

<div class="page">

<div class="name">{{ $resume['full_name'] ?? $application->resume->full_name ?? '' }}</div>
<div class="accent-block">&nbsp;</div>
<div class="contact">{{ $resume['email'] ?? $application->resume->email }} · {{ $resume['phone'] ?? $application->resume->phone }} · {{ $resume['location'] ?? $application->resume->location }}</div>

@if($resume['summary'] ?? null)
<div class="section-header">Summary</div>
<div class="section-rule">&nbsp;</div>
<div class="summary">{{ $resume['summary'] }}</div>
@endif

@if(!empty($resume['work_experience']))
<div class="section-header">Experience</div>
<div class="section-rule">&nbsp;</div>
@foreach($resume['work_experience'] as $job)
<div class="exp-entry">
<div class="exp-title">{{ $job['title'] ?? '' }}</div>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top"><span class="exp-company">{{ $job['company'] ?? '' }}</span></td>
<td valign="top" align="right"><span class="exp-dates">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – ' . $job['end_date'] : ' – Present' }}</span></td>
</tr></table>
@if(!empty($job['description']))
<div class="exp-desc">{{ $job['description'] }}</div>
@endif
</div>
@endforeach
@endif

@if(!empty($resume['skills']))
@php
    $skillsClean = array_values(array_filter($resume['skills']));
    $skillChunks = array_chunk($skillsClean, (int) ceil(count($skillsClean) / 2));
    $skillsLeft  = $skillChunks[0] ?? [];
    $skillsRight = $skillChunks[1] ?? [];
@endphp
<div class="section-header">Skills</div>
<div class="section-rule">&nbsp;</div>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="50%" valign="top" style="padding-right: 16px;">
@foreach($skillsLeft as $skill)
<div class="skill-item">· {{ $skill }}</div>
@endforeach
</td>
<td width="50%" valign="top" style="padding-left: 16px;">
@foreach($skillsRight as $skill)
<div class="skill-item">· {{ $skill }}</div>
@endforeach
</td>
</tr>
</table>
@endif

@if(!empty($resume['education']))
<div class="section-header">Education</div>
<div class="section-rule">&nbsp;</div>
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
@endif

</div>

@if($coverLetter)
<div class="cover-page">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<div class="cover-accent">&nbsp;</div>
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} · {{ $resume['phone'] ?? $application->resume->phone }} · {{ $resume['location'] ?? $application->resume->location }}</div>
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach
</div>
@endif

</body>
</html>
