<!DOCTYPE html>
<html style="background: #1a1a1a;">
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body { height: 100%; margin: 0; padding: 0; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #111827; background: #1a1a1a; margin: 0; padding: 0; }

.outer { width: 100%; border-collapse: collapse; table-layout: fixed; border: 0; }

/* ── Top accent bar (subtle indigo) ── */
.accent-row td { background-color: #4f46e5; height: 4px; line-height: 4px; font-size: 0; padding: 0; }

/* ── Left sidebar ── */
.sidebar { background-color: #1a1a1a; padding: 32px 22px; vertical-align: top; }
.side-name { font-size: 16px; font-weight: bold; color: #ffffff; word-wrap: break-word; line-height: 1.3; letter-spacing: 0.5px; margin-bottom: 16px; }
.side-contact { font-size: 8.5px; color: #9ca3af; line-height: 2.2; margin-bottom: 24px; word-wrap: break-word; }
.side-label { font-size: 7px; letter-spacing: 2.5px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #2d2d2d; padding-bottom: 5px; margin-top: 22px; margin-bottom: 10px; font-weight: bold; }
.side-skill { font-size: 9px; color: #d1d5db; line-height: 2.1; }
.side-edu { margin-bottom: 12px; word-wrap: break-word; }
.side-edu-degree { font-size: 9px; font-weight: bold; color: #e5e7eb; line-height: 1.4; }
.side-edu-meta { font-size: 8px; color: #9ca3af; line-height: 1.5; margin-top: 2px; }

/* ── Right column ── */
.main { background-color: #ffffff; padding: 32px 28px; vertical-align: top; }
.main-name { font-size: 24px; font-weight: bold; color: #111827; line-height: 1.15; letter-spacing: -0.5px; margin-bottom: 2px; }
.main-section { font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: #374151; border-bottom: 1.5px solid #e5e7eb; padding-bottom: 4px; margin-top: 24px; margin-bottom: 12px; font-weight: bold; }
.main-summary { font-size: 10px; line-height: 1.7; color: #4b5563; }
.exp-entry { margin-bottom: 18px; }
.exp-title { font-size: 11.5px; font-weight: bold; color: #111827; line-height: 1.3; }
.exp-company { font-size: 9.5px; color: #6b7280; font-style: italic; }
.exp-dates { font-size: 9px; color: #9ca3af; white-space: nowrap; }
.exp-desc { font-size: 10px; color: #4b5563; line-height: 1.65; margin-top: 5px; }

/* ── Cover letter ── */
.cover-name { font-size: 22px; font-weight: bold; color: #111827; line-height: 1.2; letter-spacing: -0.3px; }
.cover-contact { font-size: 9.5px; color: #6b7280; margin-top: 4px; }
.cover-rule { border: none; border-top: 2px solid #4f46e5; width: 36px; margin: 16px 0 28px; padding: 0; height: 0; font-size: 0; }
.cover-date { font-size: 10px; color: #9ca3af; margin-bottom: 22px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
</style>
</head>
<body>

<table class="outer" cellpadding="0" cellspacing="0" border="0">

{{-- Indigo accent bar across the top --}}
<tr class="accent-row">
<td colspan="2" style="background-color: #4f46e5; height: 4px; line-height: 4px; font-size: 0; padding: 0;">&nbsp;</td>
</tr>

<tr>

<td class="sidebar" valign="top" width="210" style="width: 210px;">
<div class="side-name">{{ $resume['full_name'] ?? $application->resume->full_name ?? '' }}</div>
<div class="side-contact">
@if(!empty($resume['email']) || !empty($application->resume->email)){{ $resume['email'] ?? $application->resume->email }}<br>@endif
@if(!empty($resume['phone']) || !empty($application->resume->phone)){{ $resume['phone'] ?? $application->resume->phone }}<br>@endif
@if(!empty($resume['location']) || !empty($application->resume->location)){{ $resume['location'] ?? $application->resume->location }}@endif
</div>

@if(!empty($resume['skills']))
<div class="side-label">Skills</div>
@foreach($resume['skills'] as $skill)
@if($skill)
<div class="side-skill">{{ $skill }}</div>
@endif
@endforeach
@endif

@if(!empty($resume['education']))
<div class="side-label">Education</div>
@foreach($resume['education'] as $edu)
<div class="side-edu">
<div class="side-edu-degree">{{ $edu['degree'] ?? '' }}</div>
<div class="side-edu-meta">{{ $edu['institution'] ?? '' }}@if(!empty($edu['year'])) · {{ $edu['year'] }}@endif</div>
</div>
@endforeach
@endif
</td>

<td class="main" valign="top">
<div style="background: #ffffff; min-height: 100%;">
<div class="main-name">{{ $resume['full_name'] ?? $application->resume->full_name ?? '' }}</div>

@if($resume['summary'] ?? null)
<div class="main-section">Summary</div>
<div class="main-summary">{{ $resume['summary'] }}</div>
@endif

@if(!empty($resume['work_experience']))
<div class="main-section">Experience</div>
@foreach($resume['work_experience'] as $job)
<div class="exp-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td valign="top"><span class="exp-title">{{ $job['title'] ?? '' }}</span></td>
<td valign="top" align="right"><span class="exp-dates">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – ' . $job['end_date'] : ' – Present' }}</span></td>
</tr></table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 2px;"><tr>
<td><span class="exp-company">{{ $job['company'] ?? '' }}</span></td>
</tr></table>
@if(!empty($job['description']))
<div class="exp-desc">{{ $job['description'] }}</div>
@endif
</div>
@endforeach
@endif
</div>
</td>

</tr>
</table>

@if($coverLetter)
<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; min-height: 1000px; background: #ffffff; page-break-before: always;">
<tr>
<td valign="top" style="background: #ffffff; padding: 56px;">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} · {{ $resume['phone'] ?? $application->resume->phone }} · {{ $resume['location'] ?? $application->resume->location }}</div>
<hr class="cover-rule">
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach
</td>
</tr>
</table>
@endif

</body>
</html>
