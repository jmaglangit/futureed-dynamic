var nsTest = nsTest || {};
nsTest.question_types = {
	mcq: {
		text: 1,
		single_picture: 2,
		multiple_pictures: 3,
		matrix_rating: 4,
		extremity_matrix: 11,
		matrix_group: 13,
		all: [1,2,3,4,11,13] /* !important - add id everytime there's new */
	},
	text: {
		short: 5,
		long: 6,
		all: [5,6] /* !important - add id everytime there's new */
	},
	numeric: {
		whole: 7,
		decimal: 8,
		percentage: 9,
		rank: 10,
		unique_ranking: 12,
		all: [7,8,9,10,12] /* !important - add id everytime there's new */
	},
	multiple_format: 99
};
nsTest.layouts = {
	mcq: {
		text: [3],
		picture: {
			single: [1,2],
			multiple: [4]
		},
		matrix: [5,12,13,14,16,17]
	},
	text: {
		short: [6],
		long: [7]
	},
	numeric: {
		whole: [8],
		decimal: [9],
		percentage: [10],
		ranking: [11],
		unique_ranking: [15]
	},
	no_intro: [13]
};

nsTest.helpers = {
	isSelectedMCQAnswer: function( q, custom_answer, a, idx ) {
		var i = parseInt(idx);

		return (typeof(q.user_answers) != 'undefined') && (typeof(q.user_answers[i]) != 'undefined') && a.id == q.user_answers[i].answer_id;
	},

	isInputTextAnswerType: function( q ) {
		return this.isShortTextQuestionSingle(q)
		|| this.isSingleNumericDecimalType(q);
	},

	isSingleMCQTextQuestion: function( q ) {
		return nsTest.layouts.mcq.text.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isMultipleMCQTextQuestion: function( q ) {
		return nsTest.layouts.mcq.text.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 1;
	},

	isMCQSinglePictureQuestion: function( q ) {
		return nsTest.layouts.mcq.picture.single.indexOf(parseInt(q.layout.id)) >= 0;
	},

	isMCQMultiplePictureQuestion: function( q ) {
		return nsTest.layouts.mcq.picture.multiple.indexOf(parseInt(q.layout.id)) >= 0;
	},

	isMCQMatrixQuestion: function( q ) {
		return nsTest.layouts.mcq.matrix.indexOf(parseInt(q.layout.id)) >= 0;
	},

	isMCQMatrixQuestionWithoutIntro: function( q ) {
		return nsTest.layouts.mcq.matrix.indexOf(parseInt(q.layout.id)) >= 0
			&& nsTest.layouts.no_intro.indexOf(parseInt(q.layout.id)) >= 0;
	},

	isMCQMatrixQuestionVerticalLayout: function( q ) {
		return nsTest.layouts.mcq.matrix.indexOf(parseInt(q.layout.id)) == 5;
	},

	isShortTextQuestionSingle: function( q ) {
		return nsTest.layouts.text.short.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isShortTextQuestionMultiple: function( q ) {
		return nsTest.layouts.text.short.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 1;
	},

	isLongTextQuestion: function( q ) {
		return nsTest.layouts.text.long.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isSingleNumericWholeType: function( q ) {
		return nsTest.layouts.numeric.whole.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isSingleNumericDecimalType: function( q ) {
		return nsTest.layouts.numeric.decimal.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isSingleNumericPercentageType: function( q ) {
		return nsTest.layouts.numeric.percentage.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isSingleNumericRankingType: function( q ) {
		return nsTest.layouts.numeric.ranking.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;
	},

	isMultipleNumericRankingType: function( q ) {
		return nsTest.layouts.numeric.ranking.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 1;
	},

	isSingleUniqueNumericRankingType: function( q ) {
		return nsTest.layouts.numeric.unique_ranking.indexOf(parseInt(q.layout.id)) >= 0 && q.has_multiple_answers == 0;	
	},

	isPointsPerAnswerSet: function(points_settings){
		return points_settings == "Points per Answer";
	},

	sectionHasSamples: function( section ) {
		return section.sample_questions.length > 0;
	},

	sectionHasStartInstruction: function(section) {
		return section.test_instructions_start != null && section.test_instructions_start.length > 1;
	},

	sectionHasIntroInstruction: function(section) {
		return section.test_instructions_intro != null && section.test_instructions_intro.length > 1;
	},

	sectionPageHasInstruction: function( section ) {
		return section.question_page_instruction;
	},

	sectionPageHasGroupQuestion: function( section ) {
		return section.questions.length && section.questions[0].question_group;
	}
}

nsTest.helpers.question = {
	hasAnswerExp: function( question ) {
                return (typeof question != 'undefined') && (typeof question.answer_exp != 'undefined') && question.answer_exp != null && question.answer_exp.length;
    }
}

nsTest.helpers.questionType = {
	isMCQ: function( id ) {
		return nsTest.question_types.mcq.all.indexOf( parseInt(id) ) >= 0;
	},

	isMCQGroup: function( id ) {
		return nsTest.question_types.mcq.matrix_group == id;
	},

	isMCQMatrix: function( id ) {
		return nsTest.question_types.mcq.matrix_group == id || nsTest.question_types.mcq.matrix_rating ==  id || nsTest.question_types.mcq.extremity_matrix == id;
	},

	isMCQNoAnswerOptions: function( id ) {
		return nsTest.question_types.mcq.matrix_group == id || nsTest.question_types.mcq.matrix_rating == id || nsTest.question_types.mcq.extremity_matrix == id;
	},

	isMultipleFormat: function( id ) {
		return nsTest.question_types.multiple_format == id;
	}
}