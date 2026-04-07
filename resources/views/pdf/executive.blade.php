<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #0f172a; background: #ffffff; }

/* ── Outer two-column table ── */
.outer { width: 100%; border-collapse: collapse; table-layout: fixed; border: 0; }

/* ── Left sidebar (200px fixed) ── */
.sidebar { background-color: #1e293b; padding: 28px 20px; vertical-align: top; }
.side-name { font-size: 15px; font-weight: bold; color: #ffffff; word-wrap: break-word; line-height: 1.3; margin-bottom: 8px; }
.side-contact { font-size: 8.5px; color: #94a3b8; line-height: 2.1; margin-bottom: 20px; word-wrap: break-word; }
.side-label { font-size: 7.5px; letter-spacing: 2px; text-transform: uppercase; color: #64748b; margin-top: 20px; margin-bottom: 8px; border-bottom: 1px solid #334155; padding-bottom: 4px; font-weight: bold; }
.side-skill { font-size: 9px; color: #cbd5e1; line-height: 2.0; }
.side-edu { margin-bottom: 12px; word-wrap: break-word; }
.side-edu-degree { font-size: 9px; font-weight: bold; color: #e2e8f0; line-height: 1.4; }
.side-edu-meta { font-size: 8px; color: #94a3b8; line-height: 1.5; margin-top: 2px; }

/* ── Right column ── */
.main { background-color: #ffffff; padding: 32px 28px; vertical-align: top; }
.main-name { font-size: 24px; font-weight: bold; color: #0f172a; line-height: 1.15; letter-spacing: -0.3px; margin-bottom: 2px; }
.main-role { font-size: 11px; color: #64748b; margin-bottom: 20px; }
.main-section { font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: #1e293b; border-bottom: 2px solid #1e293b; padding-bottom: 3px; margin-top: 22px; margin-bottom: 12px; font-weight: bold; }
.main-summary { font-size: 10px; line-height: 1.7; color: #374151; }
.exp-entry { margin-bottom: 18px; }
.exp-title { font-size: 11.5px; font-weight: bold; color: #0f172a; line-height: 1.3; }
.exp-dates { font-size: 9.5px; color: #6b7280; white-space: nowrap; }
.exp-company { font-size: 10px; color: #6b7280; font-style: italic; margin-top: 2px; margin-bottom: 5px; }
.exp-desc { font-size: 10px; color: #4b5563; line-height: 1.65; }

/* ── Cover letter page ── */
.cover-page { padding: 48px 56px; background-color: #ffffff; page-break-before: always; }
.cover-name { font-size: 22px; font-weight: bold; color: #0f172a; line-height: 1.2; letter-spacing: -0.3px; }
.cover-contact { font-size: 9.5px; color: #64748b; margin-top: 4px; }
.cover-rule { border: none; border-top: 2px solid #1e293b; width: 36px; margin: 16px 0 28px; padding: 0; height: 0; font-size: 0; }
.cover-date { font-size: 10px; color: #94a3b8; margin-bottom: 22px; }
.cover-greeting { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #374151; margin-bottom: 14px; }
.cover-sign { font-size: 10.5px; color: #374151; margin-top: 22px; }
</style>
</head>
<body>

<table class="outer" cellpadding="0" cellspacing="0" border="0">
<tr>

<td class="sidebar" valign="top" width="200" style="width: 200px;">
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
<div class="side-edu-meta">{{ $edu['institution'] ?? '' }}@if(!empty($edu['year'])) &middot; {{ $edu['year'] }}@endif</div>
</div>
@endforeach
@endif
</td>

<td class="main" valign="top">
<div class="main-name">{{ $resume['full_name'] ?? $application->resume->full_name ?? '' }}</div>
@if(!empty($application->job_title))
<div class="main-role">Targeting: {{ $application->job_title }} &nbsp;&middot;&nbsp; {{ $application->company_name }}</div>
@endif

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
<td valign="top" align="right"><span class="exp-dates">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' &ndash; ' . $job['end_date'] : ' &ndash; Present' }}</span></td>
</tr></table>
<div class="exp-company">{{ $job['company'] ?? '' }}</div>
@if(!empty($job['description']))
<div class="exp-desc">{{ $job['description'] }}</div>
@endif
</div>
@endforeach
@endif
</td>

</tr>
</table>

@if($coverLetter)
<div class="cover-page">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} &nbsp;&middot;&nbsp; {{ $resume['phone'] ?? $application->resume->phone }} &nbsp;&middot;&nbsp; {{ $resume['location'] ?? $application->resume->location }}</div>
<hr class="cover-rule">
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
<div class="cover-greeting">Dear {{ $application->company_name }} Hiring Team,</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach
<div class="cover-sign">Sincerely,<br><br><strong>{{ $resume['full_name'] ?? $application->resume->full_name }}</strong><br>{{ $resume['email'] ?? $application->resume->email }}</div>
</div>
@endif

</body>
</html>
