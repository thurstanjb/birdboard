FROM nginx:latest

ARG VHOST_URL
ENV VHOST_URL ${VHOST_URL}

COPY  ./vhost.template.conf /etc/nginx/conf.d/${VHOST_URL}.template.conf

RUN envsubst '\$VHOST_URL' < /etc/nginx/conf.d/${VHOST_URL}.template.conf > /etc/nginx/conf.d/${VHOST_URL}.conf

WORKDIR /etc/nginx/conf.d/

RUN rm ${VHOST_URL}.template.conf
