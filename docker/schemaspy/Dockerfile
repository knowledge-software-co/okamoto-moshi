FROM --platform=linux/amd64 schemaspy/schemaspy:6.2.3

ENV TZ=Asia/Tokyo

USER root

# COPY schemaspy.properties .

ADD https://repo1.maven.org/maven2/mysql/mysql-connector-java/8.0.28/mysql-connector-java-8.0.28.jar \
    /drivers_inc/mysql-connector-java-8.0.28.jar
