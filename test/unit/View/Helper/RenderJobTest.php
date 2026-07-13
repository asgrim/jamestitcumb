<?php

declare(strict_types=1);

namespace AsgrimTest\View\Helper;

use Asgrim\Value\Job;
use Asgrim\View\Helper\RenderJob;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\View\Helper\RenderJob */
final class RenderJobTest extends TestCase
{
    private RenderJob $renderJob;

    public function setUp(): void
    {
        parent::setUp();

        $this->renderJob = new RenderJob();
    }

    public function testRenderJobWithEvenIndexIsPlacedOnLeft(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringMatchesFormat('<li class="timeline-item timeline-item--left">%a', $content);
    }

    public function testRenderJobWithOddIndexIsPlacedOnRight(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 1);

        self::assertStringMatchesFormat('<li class="timeline-item timeline-item--right">%a', $content);
    }

    public function testRenderCurrentJobIncludesCurrentClassAndBadge(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(end: null), 0);

        self::assertStringContainsString('timeline-item--current', $content);
        self::assertStringContainsString('<span class="job-card__badge">Current</span>', $content);
    }

    public function testRenderPastJobHasNoCurrentBadge(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(end: '2020-01'), 0);

        self::assertStringNotContainsString('job-card__badge', $content);
    }

    public function testRenderJobWithoutLogoRendersPlaceholderWithInitial(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringContainsString('job-card__logo--placeholder" aria-hidden="true">A</div>', $content);
    }

    public function testRenderJobWithLogoRendersImage(): void
    {
        $job = Job::fromArrayData([
            'company' => 'Acme Inc',
            'title' => 'Senior Developer',
            'start' => '2018-01',
            'end' => '2020-01',
            'description' => 'A longer description.',
        ], '/images/companies/acme.png');

        $content = $this->renderJob->__invoke($job, 0);

        self::assertStringContainsString('<img class="job-card__logo" src="/images/companies/acme.png" alt="Acme Inc logo"', $content);
    }

    public function testRenderJobWithoutUrlDoesNotWrapCompanyNameInLink(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringContainsString('<h3 class="job-card__company">Acme Inc</h3>', $content);
    }

    public function testRenderJobShowsCompanyBeforeJobTitle(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringContainsString('<h3 class="job-card__company">Acme Inc</h3><p class="job-card__title">Senior Developer</p>', $content);
    }

    public function testRenderJobWithUrlWrapsCompanyNameInLink(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(url: 'https://example.com'), 0);

        self::assertStringContainsString('<a href="https://example.com">Acme Inc</a>', $content);
    }

    public function testRenderJobIncludesExpandableDescription(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringMatchesFormat('%a<summary class="job-card__toggle">Read more</summary><div class="job-card__description">A longer description.</div>%a', $content);
    }

    public function testRenderJobWithoutTagsOmitsTagList(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(), 0);

        self::assertStringNotContainsString('tag-list', $content);
    }

    public function testRenderJobWithTagsRendersTagPills(): void
    {
        $content = $this->renderJob->__invoke($this->makeJob(tags: ['PHP', 'Java']), 0);

        self::assertStringContainsString('<span class="tag-list"><span class="tag-pill">PHP</span><span class="tag-pill">Java</span></span>', $content);
    }

    /** @param string[] $tags */
    private function makeJob(string|null $end = '2020-01', string|null $url = null, array $tags = []): Job
    {
        return Job::fromArrayData([
            'company' => 'Acme Inc',
            'title' => 'Senior Developer',
            'start' => '2018-01',
            'end' => $end,
            'description' => 'A longer description.',
            'url' => $url,
            'tags' => $tags,
        ]);
    }
}
