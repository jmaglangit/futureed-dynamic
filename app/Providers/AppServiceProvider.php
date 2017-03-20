<?php namespace FutureEd\Providers;

use FutureEd\Models\Core\Module;
use FutureEd\Models\Observers\ModuleObserver;
use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Observer implementations
		Module::observe(ModuleObserver::class);



		#TODO: Find a cleaner way for this

		Validator::extend('custom_password', function ($attribute, $value, $parameters) {
			$valid = true;

			if (!preg_match("#[0-9]+#", $value)) {

				$valid = false;

			}

			if (!preg_match("#[a-zA-Z]+#", $value)) {

				$valid = false;

			}

			//to do put min to config
			if (strlen($value) < 8) {

				$valid = false;
			}

			//to do put max to config
			if (strlen($value) > 32) {

				$valid = false;
			}

			return $valid;

		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'FutureEd\Services\Registrar'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\User\UserRepositoryInterface',
			'FutureEd\Models\Repository\User\UserRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface',
			'FutureEd\Models\Repository\Validator\ValidatorRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface',
			'FutureEd\Models\Repository\PasswordImage\PasswordImageRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Student\StudentRepositoryInterface',
			'FutureEd\Models\Repository\Student\StudentRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Admin\AdminRepositoryInterface',
			'FutureEd\Models\Repository\Admin\AdminRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Token\TokenRepositoryInterface',
			'FutureEd\Models\Repository\Token\TokenRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\School\SchoolRepositoryInterface',
			'FutureEd\Models\Repository\School\SchoolRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Client\ClientRepositoryInterface',
			'FutureEd\Models\Repository\Client\ClientRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface',
			'FutureEd\Models\Repository\Avatar\AvatarRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Grade\GradeRepositoryInterface',
			'FutureEd\Models\Repository\Grade\GradeRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Country\CountryRepositoryInterface',
			'FutureEd\Models\Repository\Country\CountryRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Subject\SubjectRepositoryInterface',
			'FutureEd\Models\Repository\Subject\SubjectRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Announcement\AnnouncementRepositoryInterface',
			'FutureEd\Models\Repository\Announcement\AnnouncementRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Subscription\SubscriptionRepositoryInterface',
			'FutureEd\Models\Repository\Subscription\SubscriptionRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface',
			'FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\SubjectArea\SubjectAreaRepositoryInterface',
			'FutureEd\Models\Repository\SubjectArea\SubjectAreaRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\VolumeDiscount\VolumeDiscountRepositoryInterface',
			'FutureEd\Models\Repository\VolumeDiscount\VolumeDiscountRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface',
			'FutureEd\Models\Repository\Invoice\InvoiceRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface',
			'FutureEd\Models\Repository\Classroom\ClassroomRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface',
			'FutureEd\Models\Repository\ClassStudent\ClassStudentRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface',
			'FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Order\OrderRepositoryInterface',
			'FutureEd\Models\Repository\Order\OrderRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\ParentStudent\ParentStudentRepositoryInterface',
			'FutureEd\Models\Repository\ParentStudent\ParentStudentRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface',
			'FutureEd\Models\Repository\OrderDetail\OrderDetailRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Tip\TipRepositoryInterface',
			'FutureEd\Models\Repository\Tip\TipRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\HelpRequest\HelpRequestRepositoryInterface',
			'FutureEd\Models\Repository\HelpRequest\HelpRequestRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface',
			'FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\TipRating\TipRatingRepositoryInterface',
			'FutureEd\Models\Repository\TipRating\TipRatingRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Module\ModuleRepositoryInterface',
			'FutureEd\Models\Repository\Module\ModuleRepository'
		);
		$this->app->bind(

			'FutureEd\Models\Repository\AgeGroup\AgeGroupRepositoryInterface',
			'FutureEd\Models\Repository\AgeGroup\AgeGroupRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\CountryGrade\CountryGradeRepositoryInterface',
			'FutureEd\Models\Repository\CountryGrade\CountryGradeRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface',
			'FutureEd\Models\Repository\TeachingContent\TeachingContentRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\HelpRequestAnswerRating\HelpRequestAnswerRatingRepositoryInterface',
			'FutureEd\Models\Repository\HelpRequestAnswerRating\HelpRequestAnswerRatingRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\ModuleGroup\ModuleGroupRepositoryInterface',
			'FutureEd\Models\Repository\ModuleGroup\ModuleGroupRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\Question\QuestionRepositoryInterface',
			'FutureEd\Models\Repository\Question\QuestionRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface',
			'FutureEd\Models\Repository\ModuleContent\ModuleContentRepository'
		);
		$this->app->bind(
			'FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface',
			'FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\LearningStyle\LearningStyleRepositoryInterface',
			'FutureEd\Models\Repository\LearningStyle\LearningStyleRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\MediaType\MediaTypeRepositoryInterface',
			'FutureEd\Models\Repository\MediaType\MediaTypeRepository'
		);
        $this->app->bind(
            'FutureEd\Models\Repository\AvatarPose\AvatarPoseRepositoryInterface',
            'FutureEd\Models\Repository\AvatarPose\AvatarPoseRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\AvatarQuote\AvatarQuoteRepositoryInterface',
            'FutureEd\Models\Repository\AvatarQuote\AvatarQuoteRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Quote\QuoteRepositoryInterface',
            'FutureEd\Models\Repository\Quote\QuoteRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface',
            'FutureEd\Models\Repository\StudentModule\StudentModuleRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface',
            'FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepository'
        );

		$this->app->bind(
			'FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface',
			'FutureEd\Models\Repository\StudentModule\StudentModuleRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\StudentBadge\StudentBadgeRepositoryInterface',
			'FutureEd\Models\Repository\StudentBadge\StudentBadgeRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface',
			'FutureEd\Models\Repository\StudentPoint\StudentPointRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\Badge\BadgeRepositoryInterface',
			'FutureEd\Models\Repository\Badge\BadgeRepository'
		);

		$this->app->bind(

			'FutureEd\Models\Repository\Event\EventRepositoryInterface',
			'FutureEd\Models\Repository\Event\EventRepository'
		);

		$this->app->bind(

			'FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepositoryInterface',
			'FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepository'
		);

		$this->app->bind(

			'FutureEd\Models\Repository\PointLevel\PointLevelRepositoryInterface',
			'FutureEd\Models\Repository\PointLevel\PointLevelRepository'
		);
		
		$this->app->bind(
			'FutureEd\Models\Repository\StudentLsScore\StudentLsScoreRepositoryInterface',
			'FutureEd\Models\Repository\StudentLsScore\StudentLsScoreRepository'
		);
		
		$this->app->bind(
			'FutureEd\Models\Repository\StudentLsAnswer\StudentLsAnswerRepositoryInterface',
			'FutureEd\Models\Repository\StudentLsAnswer\StudentLsAnswerRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\UserLog\UserLogRepositoryInterface',
			'FutureEd\Models\Repository\UserLog\UserLogRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\SecurityLog\SecurityLogRepositoryInterface',
			'FutureEd\Models\Repository\SecurityLog\SecurityLogRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\AdminLog\AdminLogRepositoryInterface',
			'FutureEd\Models\Repository\AdminLog\AdminLogRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface',
			'FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\BackgroundImage\BackgroundImageRepositoryInterface',
			'FutureEd\Models\Repository\BackgroundImage\BackgroundImageRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface',
			'FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface',
			'FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\SnapExerciseDetails\SnapExerciseDetailsRepositoryInterface',
			'FutureEd\Models\Repository\SnapExerciseDetails\SnapExerciseDetailsRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\SubscriptionDay\SubscriptionDayRepositoryInterface',
			'FutureEd\Models\Repository\SubscriptionDay\SubscriptionDayRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\Game\GameRepositoryInterface',
			'FutureEd\Models\Repository\Game\GameRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\StudentGame\StudentGameRepositoryInterface',
			'FutureEd\Models\Repository\StudentGame\StudentGameRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface',
			'FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface',
			'FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface',
			'FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface',
			'FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface',
			'FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\Job\JobRepositoryInterface',
			'FutureEd\Models\Repository\Job\JobRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\ModuleCountry\ModuleCountryRepositoryInterface',
			'FutureEd\Models\Repository\ModuleCountry\ModuleCountryRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\GamePlayTime\GamePlayTimeRepositoryInterface',
			'FutureEd\Models\Repository\GamePlayTime\GamePlayTimeRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\DataLibrary\DataLibraryRepositoryInterface',
			'FutureEd\Models\Repository\DataLibrary\DataLibraryRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepositoryInterface',
			'FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\AnswerExplanationTemplate\AnswerExplanationTemplateRepositoryInterface',
			'FutureEd\Models\Repository\AnswerExplanationTemplate\AnswerExplanationTemplateRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\ModuleQuestionTemplate\ModuleQuestionTemplateRepositoryInterface',
			'FutureEd\Models\Repository\ModuleQuestionTemplate\ModuleQuestionTemplateRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuestionCache\QuestionCacheRepositoryInterface',
			'FutureEd\Models\Repository\QuestionCache\QuestionCacheRepository'
		);

		$this->app->bind(
			'FutureEd\Models\Repository\QuestionCacheLog\QuestionCacheLogRepositoryInterface',
			'FutureEd\Models\Repository\QuestionCacheLog\QuestionCacheLogRepository'
		);


	}
}
