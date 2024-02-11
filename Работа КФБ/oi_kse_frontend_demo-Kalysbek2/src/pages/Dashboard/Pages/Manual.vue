<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-blue">
          <div class="card-icon">
            <md-icon>receipt</md-icon>
          </div>
          <h4 class="title">
            {{ $t('pageManual.title') }}
          </h4>
        </md-card-header>
        <md-card-content>
          <time-line plain type="simple">
            <time-line-item
              inverted
              badge-type="danger"
              badge-icon="card_travel"
            >
              <p slot="content">
                {{ $t('pageManual.introductory') }}
              </p>

              <h6 slot="footer">
                <i class="ti-time"></i>
              </h6>
            </time-line-item>

            <time-line-item
              inverted
              badge-type="success"
              badge-icon="fingerprint"
            >
              <span slot="header" class="badge badge-success">{{
                $t('pageManual.loginTitle')
              }}</span>
              <p slot="content">
                {{ $t('pageManual.loginText') }}
              </p>
            </time-line-item>

            <time-line-item inverted badge-type="primary" badge-icon="vpn_key">
              <span slot="header" class="badge badge-primary">{{
                $t('pageManual.elecSignatureTitle')
              }}</span>
              <p slot="content">
                {{ $t('pageManual.elecSignatureText.1') }} <br />{{
                  $t('pageManual.elecSignatureText.2')
                }}
                <br />
                {{ $t('pageManual.elecSignatureText.3') }}
              </p>
            </time-line-item>

            <time-line-item inverted badge-type="info" badge-icon="filter_1">
              <span slot="header" class="badge badge-info">{{
                $t('pageManual.createReportTitle')
              }}</span>
              <div slot="content">
                <p>{{ $t('pageManual.createReportText.1') }}</p>
                <p>{{ $t('pageManual.createReportText.2') }}</p>
              </div>
            </time-line-item>

            <time-line-item inverted badge-type="info" badge-icon="filter_2">
              <span slot="header" class="badge badge-info">{{
                $t('pageManual.sendingDocumentsTitle')
              }}</span>
              <div slot="content">
                <p>
                  {{ $t('pageManual.sendingDocumentsText.1') }}
                </p>
                <p>
                  {{ $t('pageManual.sendingDocumentsText.2') }}
                </p>
              </div>
            </time-line-item>

            <time-line-item inverted badge-type="info" badge-icon="filter_3">
              <span slot="header" class="badge badge-info">{{
                $t('pageManual.gettingConfirmTitle')
              }}</span>
              <div slot="content">
                <p>
                  {{ $t('pageManual.gettingConfirmText.1') }}
                </p>
                <p>
                  {{ $t('pageManual.gettingConfirmText.2') }}
                </p>
              </div>
            </time-line-item>
          </time-line>
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>

<script>
import {TimeLine, TimeLineItem} from '@/components'

export default {
  components: {
    TimeLine,
    TimeLineItem
  },
  props: {},
  data() {
    return {}
  },
  methods: {},
  mounted() {}
}
</script>

<style lang="css"></style>
