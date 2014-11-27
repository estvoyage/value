<?php

$runner
	->addTestsFromDirectory(__DIR__ . '/tests/units/classes')
	->disallowUndefinedMethodInInterface()
;

$coverallsToken = getenv('COVERALLS_REPO_TOKEN');

if ($coverallsToken)
{
	$coverallsReport = new reports\asynchronous\coveralls(__DIR__ . '/classes', $coverallsToken);

	$defaultFinder = $coverallsReport->getBranchFinder();

	$coverallsReport
		->setBranchFinder(function() use ($defaultFinder) {
				if (($branch = getenv('TRAVIS_BRANCH')) === false)
				{
					$branch = $defaultFinder();
				}

				return $branch;
			}
		)
		->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
		->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
		->addDefaultWriter()
	;

	$runner->addReport($coverallsReport);
}
