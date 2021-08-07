ifneq (,$(wildcard ./.env))
    include .env
    export
endif

all:
	php artisan rabbitmq:queue-declare ${RABBITMQ_QUEUE};
	php artisan rabbitmq:queue-declare ${RABBIT_MQ_EXPERIENCE_QUEUE};
	php artisan rabbitmq:queue-declare ${RABBIT_MQ_ACHIEVEMENTS_QUEUE};
	php artisan rabbitmq:exchange-declare ${RABBIT_MQ_RESULTS_EXCHANGE} --type=direct;
	php artisan rabbitmq:queue-bind ${RABBITMQ_QUEUE} ${RABBIT_MQ_RESULTS_EXCHANGE};
	php artisan rabbitmq:queue-bind ${RABBIT_MQ_EXPERIENCE_QUEUE} ${RABBIT_MQ_RESULTS_EXCHANGE} --routing-key=${RABBIT_MQ_EXPERIENCE_QUEUE};
	php artisan rabbitmq:queue-bind ${RABBIT_MQ_ACHIEVEMENTS_QUEUE} ${RABBIT_MQ_RESULTS_EXCHANGE} --routing-key=${RABBIT_MQ_ACHIEVEMENTS_QUEUE};
