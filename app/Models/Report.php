<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Report extends Model
{
    use SoftDeletes;

    protected $dates = ['generated_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'results' => 'array'
    ];

    public $categories = [
        'seo' => ['title', 'meta_description', 'headings', 'content_keywords', 'image_keywords', 'seo_friendly_url', '404_page', 'robots', 'noindex', 'in_page_links', 'language', 'favicon'],
        'performance' => ['text_compression', 'load_time', 'page_size', 'http_requests', 'image_format', 'defer_javascript', 'dom_size'],
        'security' => ['https_encryption', 'mixed_content', 'server_signature', 'unsafe_cross_origin_links', 'plaintext_email'],
        'miscellaneous' => ['structured_data', 'meta_viewport', 'charset', 'sitemap', 'social', 'content_length', 'text_html_ratio', 'inline_css', 'deprecated_html_tags']
    ];

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('url', 'like', '%' . cleanUrl($value) . '%');
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchProject(Builder $query, $value)
    {
        return $query->where('project', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeOfUser(Builder $query, $value)
    {
        return $query->where('user_id', '=', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeOfProject(Builder $query, $value)
    {
        return $query->where('project', '=', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeOfResult(Builder $query, $value)
    {
        if ($value == 'good') {
            return $query->where('result', '>', 79);
        } elseif ($value == 'decent') {
            return $query->where([['result', '>=', 49], ['result', '<=', 79]]);
        }

        return $query->where('result', '<', 49);
    }

    /**
     * Get the user that owns the Link.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * Get the total score possible.
     */
    public function getTotalScoreAttribute()
    {
        $points = 0;
        foreach ($this->results as $key => $value) {
            $points += config('settings.report_score_' . $value['importance']);
        }

        return $points;
    }

    /**
     * Get the current score.
     */
    public function getScoreAttribute()
    {
        $points = 0;
        foreach ($this->results as $key => $value) {
            if ($value['passed']) {
                $points += config('settings.report_score_' . $value['importance']);
            }
        }

        return $points;
    }

    /**
     * Get the total high issues count.
     */
    public function getHighIssuesCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            if (!$value['passed'] && $value['importance'] == 'high') {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Get the total medium issues count.
     */
    public function getMediumIssuesCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            if (!$value['passed'] && $value['importance'] == 'medium') {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Get the total low issues count.
     */
    public function getLowIssuesCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            if (!$value['passed'] && $value['importance'] == 'low') {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Get the total non-issues count.
     */
    public function getNonIssuesCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            if ($value['passed']) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Get the total Tests count.
     */
    public function getTotalTestsCountAttribute()
    {
        return count($this->results);
    }

    /**
     * Get the high issues SEO count.
     */
    public function getHighIssuesSeoCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['seo'])) {
                if (!$value['passed'] && $value['importance'] == 'high') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the high issues Performance count.
     */
    public function getHighIssuesPerformanceCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['performance'])) {
                if (!$value['passed'] && $value['importance'] == 'high') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the high issues Security count.
     */
    public function getHighIssuesSecurityCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['security'])) {
                if (!$value['passed'] && $value['importance'] == 'high') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the high issues Miscellaneous count.
     */
    public function getHighIssuesMiscellaneousCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['miscellaneous'])) {
                if (!$value['passed'] && $value['importance'] == 'high') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the medium issues SEO count.
     */
    public function getMediumIssuesSeoCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['seo'])) {
                if (!$value['passed'] && $value['importance'] == 'medium') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the medium issues Performance count.
     */
    public function getMediumIssuesPerformanceCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['performance'])) {
                if (!$value['passed'] && $value['importance'] == 'medium') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the medium issues Security count.
     */
    public function getMediumIssuesSecurityCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['security'])) {
                if (!$value['passed'] && $value['importance'] == 'medium') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the medium issues Miscellaneous count.
     */
    public function getMediumIssuesMiscellaneousCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['miscellaneous'])) {
                if (!$value['passed'] && $value['importance'] == 'medium') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the low issues SEO count.
     */
    public function getLowIssuesSeoCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['seo'])) {
                if (!$value['passed'] && $value['importance'] == 'low') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the low issues Performance count.
     */
    public function getLowIssuesPerformanceCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['performance'])) {
                if (!$value['passed'] && $value['importance'] == 'low') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the low issues Security count.
     */
    public function getLowIssuesSecurityCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['security'])) {
                if (!$value['passed'] && $value['importance'] == 'low') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the low issues Miscellaneous count.
     */
    public function getLowIssuesMiscellaneousCountAttribute()
    {
        $count = 0;
        foreach ($this->results as $key => $value) {
            // If the result key exists under a category
            if (in_array($key, $this->categories['miscellaneous'])) {
                if (!$value['passed'] && $value['importance'] == 'low') {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * Get the categories
     */
    public function getCategoriesAttribute()
    {
        return $this->categories;
    }

    /**
     * Get the URL in full.
     */
    public function getFullUrlAttribute()
    {
        return $this['results']['seo_friendly_url']['value'];
    }

    /**
     * Set the url attribute.
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = cleanUrl($value);
    }

    /**
     * Set the project attribute
     */
    public function setProjectAttribute($value)
    {
        $this->attributes['project'] = parse_url(str_replace(['https://www.', 'http://www.'], ['https://', 'http://'], $value), PHP_URL_HOST);
    }

    /**
     * Get the host attribute
     */
    public function getHostAttribute()
    {
        return parse_url('http://' . $this->url, PHP_URL_HOST);
    }

    /**
     * Encrypt the report's password.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    /**
     * Decrypt the report's password.
     *
     * @param $value
     * @return string
     */
    public function getPasswordAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
